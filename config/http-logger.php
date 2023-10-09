<?php

return [
    /*
     *  Automatic registration of middleware will only happen if this setting is `true`
     */
    'enabled' => env('HTTP_LOGGER_ENABLED', true),

    /*
     * The log profile which determines whether a request should be logged.
     * It should implement `LogProfile`.
     */
    'log_profile' => \AgeekDev\HttpLogger\LogNonGetRequests::class,

    /*
     * The log writer used to write the request to a log.
     * It should implement `LogWriter`.
     */
    'log_writer' => \AgeekDev\HttpLogger\DefaultLogWriter::class,

    /*
     * The log channel used to write the request.
     */
    'log_channel' => env('LOG_CHANNEL', 'stderr'),

    /*
     * The log level used to log the request.
     */
    'log_level' => 'info',

    /*
     * List of request methods that will be logged.
     */
    'request_methods' => ['post', 'put', 'patch', 'delete'],

    /*
     * Filter out body fields which will never be logged.
     */
    'except' => [
        'password',
        'password_confirmation',
    ],

    /*
     * List of headers that will be sanitized. For example Authorization, Cookie, Set-Cookie...
     */
    'sanitize_headers' => [],
];
