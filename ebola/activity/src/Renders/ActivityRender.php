<?php

namespace Ebola\Activity\Renders;

use Ebola\Activity\Activity;

use Validator;
use Carbon\Carbon;

class ActivityRender extends Activity
{
    private $activity;

    public function __construct($user=null, $rowCount=null)
    {
        $this->activity = new Activity($user, $rowCount);
    }

    public function renderUserActivity()
    {
        $rows     = $this->activity->getRows();

        $rows     = $rows->paginate($this->activity->getRowCount());

        return view('admin.activity.user_activity', compact('rows'));
    }

    public function renderDownloadActivity()
    {
        $request = request();

        if ($request->has('date_start') || $request->has('date_end')) {
            $validator = Validator::make($request->all(), [
                'date_start' => 'required|date',
                'date_end'   => 'required|date|after:date_start',
            ]);

            if ($validator->fails()) {
                return view('admin.activity.download_activity')->withErrors($validator);
            } else {
                $this->activity->setParameters($request->all());

                $this->activity->getActivityFile();
            }
        }

        return view('admin.activity.download_activity');
    }
}
