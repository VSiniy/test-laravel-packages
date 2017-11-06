<?php

namespace Ebola\Activity;

use Spatie\Activitylog\Models\Activity;

class Activity
{
    const ROW_ACTIVITY_COUNT = 15;
    const FILE_ACTIVITY_PATH = '/reports/';

    protected $user;
    protected $rowCount;
    protected $parameters = [];

    public function __construct($user=null, $rowCount=null)
    {
        $this->user     = $user;
        $this->rowCount = $rowCount ?? self::ROW_ACTIVITY_COUNT;
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

    protected function getActivityFile()
    {
        $user       = $this->getUser();
        $parameters = $this->getParameters();

        $filename   = (!is_null($user) ? 'user_id_' . $user->id . '_' : '') . 'activity_' . date('d-m-Y_H-i-s') . '.csv';
        $out        = fopen(public_path() . self::FILE_ACTIVITY_PATH . $filename, 'w');

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
            __('admin.activity.fields.id'),
            __('admin.activity.fields.log_name'),
            __('admin.activity.fields.subject_id'),
            __('admin.activity.fields.subject_type'),
            __('admin.activity.fields.causer_id'),
            __('admin.activity.fields.causer_type'),
            __('admin.activity.fields.description'),
            __('admin.activity.fields.properties'),
            __('admin.activity.fields.created_at'),
            __('admin.activity.fields.updated_at'),
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

        header('Location: ' . asset(self::FILE_ACTIVITY_PATH . $filename));
        header("Cache-Control: public");
        header('Content-Description: File Transfer');
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header("Content-Transfer-Encoding: binary");
        header('Content-Length: ' . filesize(public_path() . self::FILE_ACTIVITY_PATH . $filename));

        exit;
    }
}
