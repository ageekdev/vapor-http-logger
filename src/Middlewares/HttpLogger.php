<?php

namespace AgeekDev\HttpLogger\Middlewares;

use AgeekDev\HttpLogger\LogProfile;
use AgeekDev\HttpLogger\LogWriter;
use Closure;
use Illuminate\Http\Request;

class HttpLogger
{
    protected LogProfile $logProfile;

    protected LogWriter $logWriter;

    public function __construct(LogProfile $logProfile, LogWriter $logWriter)
    {
        $this->logProfile = $logProfile;
        $this->logWriter = $logWriter;
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->logProfile->shouldLogRequest($request)) {
            $this->logWriter->logRequest($request);
        }

        return $next($request);
    }
}
