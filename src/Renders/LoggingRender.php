<?php

namespace Ebola\Logging\Renders;

use Ebola\Logging\Logging;

use Validator;
use Carbon\Carbon;

class LoggingRender extends Logging
{
    private $logging;

    public function __construct($user=null, $rowCount=null)
    {
        $this->logging            = new Logging($user, $rowCount);
    }

    public function renderUserLogging()
    {
        $pathToTranslations = $this->pathToTranslations;

        $rows     = $this->logging->getRows();

        $rows     = $rows->paginate($this->logging->getRowCount());

        return view('logging::user_logging', compact('rows', 'pathToTranslations'));
    }

    public function renderDownloadLogging()
    {
        $pathToTranslations = $this->pathToTranslations;

        $request = request();

        if ($request->has('date_start') || $request->has('date_end')) {
            $validator = Validator::make($request->all(), [
                'date_start' => 'required|date',
                'date_end'   => 'required|date|after:date_start',
            ]);

            if ($validator->fails()) {
                return view('logging::download_logging', compact('pathToTranslations'))->withErrors($validator);
            } else {
                $this->logging->setParameters($request->all());

                $this->logging->getLoggingFile();
            }
        }

        return view('logging::download_logging', compact('pathToTranslations'));
    }
}
