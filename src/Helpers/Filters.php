<?php

namespace Ebola\Logging\Helpers;

class Filters
{
    const SELECT_DEFAULT_KEY = 'default';
    const SELECT_NULL_KEY    = 'null';

    public static function getFilter($field, $translate)
    {   
        $fieldsForFilterSelect = config('logging.logging_filters.selectable');
        $fieldsForFilterText   = config('logging.logging_filters.according_to_the_text');

        if (in_array($field, $fieldsForFilterSelect)) {
            $resultHtml = self::getSelectFilter($field, $translate);
        } elseif (in_array($field, $fieldsForFilterText)) {
            $resultHtml = self::getTextFilter($field, $translate);
        } else {
            $resultHtml = null;
        }

        return $resultHtml;
    }

    private static function getSelectFilter($field, $translate)
    {
        $activityModel = config('activitylog.activity_model');

        $values = $activityModel::select([$field])->distinct()->orderBy($field)->get();

        $arrayValues[self::SELECT_DEFAULT_KEY] = $translate;
        foreach ($values as $value) {
            if (!is_null($value->{$field})) {
                $arrayValues[$value->{$field}] = $value->{$field};
            } else {
                $arrayValues[self::SELECT_NULL_KEY] = __('logging::logging.user_logging.undefined');
            }
        }

        return view('logging::filters._select_filter', compact('field', 'arrayValues'));
    }
     
    private static function getTextFilter($field, $translate)
    {
        return view('logging::filters._text_filter', compact('field', 'translate'));
    }
}
