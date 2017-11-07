<?php

namespace Ebola\Logging;

use Spatie\Activitylog\Models\Activity;

class Logging
{
    protected $user;
    protected $rowCount;
    protected $fileLoggingPath;
    protected $parameters = [];

    public function __construct($user, $rowCount)
    {
        $this->user            = $user;
        $this->rowCount        = $rowCount ?? config('logging.num_rows_on_page');
        $this->fileLoggingPath = config('logging.download_path');
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function getFileLoggingPath()
    {
        return $this->fileLoggingPath;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    protected function getRows()
    {
        $user = $this->getUser();

        $rows = Activity::select(['*']);

        if (isset($user))
            $rows = $rows->where('causer_id', $user->id);

        return $rows;
    }

    protected function getLoggingFile()
    {
        $fileLoggingPath = $this->getFileLoggingPath();

        $user       = $this->getUser();
        $parameters = $this->getParameters();

        $filename   = (!is_null($user) ? 'user_id_' . $user->id . '_' : '') . 'logging_' . date('d-m-Y_H-i-s') . '.csv';
        $out        = fopen(public_path() . $fileLoggingPath . $filename, 'w');

        if (array_key_exists('date_start', $parameters))
            $startDate = Carbon::parse($parameters['date_start'])->startOfDay()->format('Y-m-d H:i:s');

        if (array_key_exists('date_end', $parameters))
            $endDate   = Carbon::parse($parameters['date_end'])->endOfDay()->format('Y-m-d H:i:s');

        $rows = $this->getRows(); 

        if (isset($startDate) && isset($endDate)) 
            $rows = $rows->whereBetween('created_at', array($startDate, $endDate));

        $rows = $rows->get();

        fwrite($out, "\xEF\xBB\xBF");
        fputcsv($out, [
            __('admin.logging.fields.id'),
            __('admin.logging.fields.log_name'),
            __('admin.logging.fields.subject_id'),
            __('admin.logging.fields.subject_type'),
            __('admin.logging.fields.causer_id'),
            __('admin.logging.fields.causer_type'),
            __('admin.logging.fields.description'),
            __('admin.logging.fields.properties'),
            __('admin.logging.fields.created_at'),
            __('admin.logging.fields.updated_at'),
        ], ';');

        foreach($rows as $row) {
            fputcsv($out, [
                $row->id,
                $row->log_name,
                $row->subject_id,
                $row->subject_type,
                $row->causer_id,
                $row->causer_type,
                $row->description,
                $row->properties,
                $row->created_at->format('d.m.Y'),
                $row->updated_at->format('d.m.Y'),
            ], ';');
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
}
