<?php

namespace Ebola\Logging;

use Ebola\Logging\Helpers\Filters;

class Logging
{
    protected $user;
    protected $fields;
    protected $rowCount;
    protected $fileLoggingPath;
    protected $activityModel;
    protected $translationPath;

    public function __construct($user, $fields)
    {
        $this->user            = $user;
        $this->fields          = $fields ?? config('logging.logging_fields');
        $this->rowCount        = config('logging.num_rows_on_page');
        $this->fileLoggingPath = config('logging.download_path');
        $this->activityModel   = config('activitylog.activity_model');
        $this->translationPath = config('logging.translation_path');
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function getFileLoggingPath()
    {
        return $this->fileLoggingPath;
    }

    public function getActivityModel()
    {
        return $this->activityModel;
    }

    public function getTranslationPath()
    {
        return $this->translationPath;
    }

    public function getTranslatedFields()
    {
        $translationPath = $this->getTranslationPath() ?? 'logging::logging.fields';

        $translatedFields = [];
        foreach ($this->getFields() as $field) {
            $translatedFields[$field] = __($translationPath . '.' . $field);
        }

        return $translatedFields;
    }

    protected function getRows($filters=[])
    {
        $user          = $this->getUser();
        $activityModel = $this->getActivityModel();

        $rows = $activityModel::select(['*']);

        if (isset($user))
            $rows = $rows->where('causer_id', $user->id);

        if (!empty($filters))
            $rows = $this->getFilteredQuery($rows, $filters);

        return $rows;
    }

    protected function getLoggingFile($rows)
    {
        $fileLoggingPath = $this->getFileLoggingPath();

        $user       = $this->getUser();

        $filename   = (!is_null($user) ? 'user_id_' . $user->id . '_' : '') . 'logging_' . date('d-m-Y_H-i-s') . '.csv';
        $out        = fopen(public_path() . $fileLoggingPath . $filename, 'w');

        fwrite($out, "\xEF\xBB\xBF");
        fputcsv($out, $this->getTranslatedFields(), ';');

        foreach($rows ?? [] as $row) {

            $fieldsForSave = [];
            foreach ($this->getFields() as $field) {
                $fieldsForSave[] = $row->{$field};
            }

            fputcsv($out, $fieldsForSave, ';');
        }

        fclose($out);

        header('Location: ' . asset($fileLoggingPath . $filename));
        header("Cache-Control: public");
        header('Content-Description: File Transfer');
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header("Content-Transfer-Encoding: binary");
        header('Content-Length: ' . filesize(public_path() . $fileLoggingPath . $filename));

        exit;
    }

    private function getFilteredQuery($rows, $filters)
    {
        $selectable         = config('logging.logging_filters.selectable');
        $accordingToTheText = config('logging.logging_filters.according_to_the_text');

        foreach ($filters as $field => $value) {
            if (in_array($field, $selectable) && ($value !== Filters::SELECT_DEFAULT_KEY)) {
                if ($value !== Filters::SELECT_NULL_KEY) {
                    $rows = $rows->where($field, '=', $value);
                } else {
                    $rows = $rows->where($field, '=', null);
                }
            }

            if (in_array($field, $accordingToTheText) && !is_null($value))
                $rows = $rows->where($field, 'like', '%' . $value . '%');

        }

        return $rows;
    }
}
