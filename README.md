# Save and display global logs with log activity from Laravel Activitylog v.2 

[![Latest Version](https://img.shields.io/github/release/VSiniy/test-laravel-packages.svg?style=flat-square)](https://github.com/VSiniy/test-laravel-packages/releases)

This Laravel >=5.5 package. It provides a simple API to work with and version Laravel Activitylog. To learn all about Laravel Activitylog, head over to [the extensive documentation](https://docs.spatie.be/laravel-activitylog/v2).

Here are a few short examples of what you can do:

```php
$logging = new LoggingRender();
```

It can display all user activity on front:

```php
{!! $logging->renderUserLogging() !!}
```

Or display form for download users activity:

```php
{!! $logging->renderDownloadLogging() !!}
```

## Installation

You can install this package via composer using this command:

```bash
composer require ebola/logging
```

Next, you must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    Ebola\Logging\LoggingServiceProvider::class,
];
```

And add aliase:

```php
// config/app.php
'aliases' => [
    ...
    'LoggingRender' => Ebola\Logging\Renders\LoggingRender::class,
    'LoggingFilters' => Ebola\Logging\Helpers\Filters::class,
    'LoggingProperties' => Ebola\Logging\Helpers\Properties::class,
];
```

You must publish activitylog migration:

```bash
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="migrations"
```

You must migrate:

```bash
php artisan migrate
```

You can optionally publish the activitylog config file:

```bash
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="config"
```

You can publish the views with:

```bash
php artisan vendor:publish --provider="Ebola\Logging\LoggingServiceProvider" --tag="views"
```

You can publish the assets with:

```bash
php artisan vendor:publish --provider="Ebola\Logging\LoggingServiceProvider" --tag="public"
```

You can publish the translations with:

```bash
php artisan vendor:publish --provider="Ebola\Logging\LoggingServiceProvider" --tag="translations"
```

You can publish the config-file with:

```bash
php artisan vendor:publish --provider="Ebola\Logging\LoggingServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [

    /*
     * Route prefixes for save transitions on the URL
     * 'web' is all routes without prefix
     */
    'logging_routing_prefixes' => [
        'web',
        // 'admin',
    ],

    /*
     * Save transition if route is ajax query
     */
    'logging_routing_save_ajax' => false,

    /*
     * Users events for save
     */
    'logging_users_events' => [
        'registered',
        'attempting',
        // 'authenticated',
        'login',
        'failed',
        'logout',
        'lockout',
        'password_reset',
    ],

    /*
     * Models events for save
     */
    'logging_models_events' => [
        'created',
        'updated',
        'deleted',
    ],

    /*
     * Number rows for display on one page paginate
     */
    'num_rows_on_page' => 15,

    /*
     * Path to folder where logging files are saving
     */
    'download_path' => '/reports/',

    /*
     * List of logging models fields
     */
    'logging_fields' => [
        'id',
        'log_name',
        'subject_id',
        'subject_type',
        'causer_id',
        'causer_type',
        'description',
        // 'properties',
        'created_at',
        // 'updated_at',
    ],

    /*
     * Path to translated logging fields
     * Need path to fields translates in "dot" notation
     */
    'translation_path' => null, // 'admin.logging.fields' => []

    /*
     * Filters for fields
     * Types of filter and fields for it
     */
    'logging_filters' => [
        'selectable' => [
            'log_name',
            'subject_type',
            'causer_id',
        ],

        'according_to_the_text' => [
            'created_at',
        ],
    ],
];
```

## Usage

You can log users routing, user activity and mails:

```php
// App\Providers\EventServiceProvider.php
protected $subscribe = [
    'Ebola\Logging\Listeners\RequestEventLogging',
    'Ebola\Logging\Listeners\UserEventLogging',
    'Ebola\Logging\Listeners\MailEventLogging',
];
```

You can log models events:

```php
// App\Providers\AppServiceProvider.php

use Ebola\Logging\LoggingObserver;

...

public function boot()
    {
        //

        Article::observe(LoggingObserver::class);
    }
```

## Display logs

You must make object of LoggingRender class. You can transfer as a parameter the user object to display only its logs, as well as a list of fields to display on the screen or save them. If the values are not transferred, you will output all the logs with the fields specified in the config file.

```php
    $logging = new LoggingRender();

    // or

    $logging = new LoggingRender(\Auth::user(), ['id', 'log_name', 'description']);
```

You have two protected methods for display logs:

```php
    {!! $logging->renderUserLogging() !!}

    {!! $logging->renderDownloadLogging() !!}
```

If you use rendering methods, do not forget to call css and js for the correct display:

```php
    <link rel="stylesheet" href="{{ asset('vendor/logging/css/styles.css') }}">

    <script src="{{ asset('vendor/logging/js/common.js') }}"></script>
```

In each of them, methods are available to retrieve records and create a file to load it

```php
    // User in logging object
    $loggingUser = $this->getUser();

    // Path to download directory from config download_path
    $fileLoggingPath = $this->getFileLoggingPath();

    // Path to activity model from config activitylog.activity_model
    $activityModel = $this->getActivityModel();

    // Path to translation path from config translation_path
    $pathToTranslationFields = $this->getTranslationPath();

    // From config num_rows_on_page
    $countRowOnDisplayFromConfig = $this->logging->getRowCount();

    // Fields from object. Default from config logging_fields
    $fieldsForDisplay = $this->logging->getFields();

    // Translates from config translation_path. Default from vendor
    $translatedFieldsForDisplay = $this->logging->getTranslatedFields();

    // Returns the constructed query
    // Fields must exist in the log table and be broken according to the type of filtering in the config logging_filters
    // Default filters are empty array
    $rows = $this->logging->getRows($filters);

    // Creates a file and displays a custom save window
    $rows = $this->logging->getRows()->get()
    $this->logging->getLoggingFile($rows);
```

There are also 2 static classes to help in the output of the properties of the logged models and the display of filters

```php
    // Work with json properties field from Activity model
    class Properties
    {
        public static function getProperties($activity, $flag='attributes')
        {   
            $properties = $activity->properties->toArray();

            return array_key_exists($flag, $properties) ? $properties[$flag] : null;
        }

        public static function getPropertiesChanges($activity)
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

        public static function getPropertiesArray($model)
        {
            $attributes    = $model->getAttributes();
            $oldAttributes = $model->getOriginal();
        
            $properties['attributes'] = $attributes;

            $checkAttributes = false;
            foreach ($attributes as $key => $value) {
                if (!empty($oldAttributes) && ($oldAttributes[$key] != $value)) {
                    $checkAttributes = true;
                    break;
                }
            }

            if ($checkAttributes) 
                $properties['old']    = $oldAttributes;

            return $properties;
        }
    }
```

```php
    // Display filter if transmitted field is in array from config logging_filters
    class Filters
    {
        const SELECT_DEFAULT_KEY = 'default';

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
                    $arrayValues['null'] = __('logging::logging.user_logging.undefined');
                }
            }

            return view('logging::filters._select_filter', compact('field', 'arrayValues'));
        }
     
        private static function getTextFilter($field, $translate)
        {
            return view('logging::filters._text_filter', compact('field', 'translate'));
        }
    }
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.