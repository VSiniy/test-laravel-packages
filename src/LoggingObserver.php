<?php

namespace Ebola\Logging;

use Ebola\Logging\Helpers\Properties;

class LoggingObserver
{
    const CREATED_EVENT = 'created';
    const UPDATED_EVENT = 'updated';
    const DELETED_EVENT = 'deleted';

    public $loggingModelsEvents;

    public function __construct()
    {
        $this->loggingModelsEvents = config('logging.logging_models_events');
    }

    /**
     * Listen to the model created event.
     *
     * @param  \App\Models\SomeModel  $someModel
     * @return void
     */
    public function created($model)
    {
        if (in_array(self::CREATED_EVENT, $this->loggingModelsEvents))
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
        if (in_array(self::UPDATED_EVENT, $this->loggingModelsEvents))
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
        if (in_array(self::DELETED_EVENT, $this->loggingModelsEvents))
            activity('deleted')->performedOn($model)
                               ->withProperties(Properties::getPropertiesArray($model))
                               ->log('The ' . class_basename($model) . ' was deleted');
    }
}
