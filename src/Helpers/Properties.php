<?php

namespace Ebola\Logging\Helpers;

use Spatie\Activitylog\Models\Activity;

class Properties
{
    public static function getProperties(Activity $activity, $flag='attributes')
    {   
        $properties = $activity->properties->toArray();

        return array_key_exists($flag, $properties) ? $properties[$flag] : null;
    }

    public static function getPropertiesChanges(Activity $activity)
    {
        $attributes = self::getProperties($activity, 'attributes');
        $old        = self::getProperties($activity, 'old');

        $result = [];
        foreach ($attributes ?? [] as $key => $value) {
            if (isset($old) && ($attributes[$key] != $old[$key])) {
                $result[] = $key;
            }
        }

        return !empty($result) ? $result : null;
    }

    /**
     * Get properties for log.
     *
     * @param  \App\Models\SomeModel  $someModel
     * @return array $properties
     */
    public static function getPropertiesArray($model)
    {
        $attributes    = $model->getAttributes();
        $oldAttributes = $model->getOriginal();
        
        $properties['attributes'] = $attributes;

        $checkAttributes = false;
        foreach ($attributes as $key => $value) {
            if ($oldAttributes[$key] != $value) {
                $checkAttributes = true;
                break;
            }
        }

        if ($checkAttributes) 
            $properties['old']    = $oldAttributes;

        return $properties;
    }
}
