<?php

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
        'properties',
        'created_at',
        // 'updated_at',
    ],

    /*
     * Path to translated logging fields
     * Need path to fields translates in "dot" notation
     */
    'translation_path' => null, // 'admin.logging.fields => []'
];