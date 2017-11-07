<?php

return [

    /*
     * Route prefixes for save transitions on the URL
     * 'web' is all routes without prefix
     */
    'logging_routing_prefixes' => [
        'web',
        'admin',
    ],

    /*
     * Save transition if route is ajax query
     */
    'logging_routing_save_ajax' => false,

    /*
     * Users events for save
     */
    'logging_users' => [
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
     * Number rows for display on one page paginate
     */
    'num_rows_on_page' => 15,

    /*
     * Path to folder where logging files are saving
     */
    'download_path' => '/reports/',
];