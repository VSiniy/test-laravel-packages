<?php

namespace Ebola\Activity;

use Ebola\Activity\Helpers\Properties;

class ActivityObserver
{
    /**
     * Listen to the model created event.
     *
     * @param  \App\Models\SomeModel  $someModel
     * @return void
     */
    public function created($model)
    {
        activity('created')->performedOn($model)
                           ->withProperties(Properties::getPropertiesArray($model))
                           ->log('The ' . class_basename($model) . ' was created');
    }

    /**
     * Listen to the model updating event.
     *
     * @param  \App\Models\SomeModel  $someModel
     * @return void
     */
    public function updating($model)
    {
        activity('updated')->performedOn($model)
                           ->withProperties(Properties::getPropertiesArray($model))
                           ->log('The ' . class_basename($model) . ' was updated');
    }

    /**
     * Listen to the model deleting event.
     *
     * @param  \App\Models\SomeModel  $someModel
     * @return void
     */
    public function deleting($model)
    {
        activity('deleted')->performedOn($model)
                           ->withProperties(Properties::getPropertiesArray($model))
                           ->log('The ' . class_basename($model) . ' was deleted');
    }
}
