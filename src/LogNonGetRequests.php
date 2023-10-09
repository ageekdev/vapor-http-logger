<?php

namespace AgeekDev\HttpLogger;

use Illuminate\Http\Request;

class LogNonGetRequests implements LogProfile
{
    public function shouldLogRequest(Request $request): bool
    {
        return in_array(strtolower($request->method()), config('http-logger.request_methods', ['post', 'put', 'patch', 'delete']));
    }
}
