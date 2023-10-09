<?php

namespace AgeekDev\HttpLogger;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DefaultLogWriter implements LogWriter
{
    protected $sanitizer;

    public function logRequest(Request $request): void
    {
        $message = $this->formatMessage($this->getMessage($request));

        Log::channel(config('http-logger.log_channel', 'stderr'))->log(config('http-logger.log_level', 'info'), $message);
    }

    public function getMessage(Request $request): array
    {
        $files = (new Collection(iterator_to_array($request->files)))
            ->map([$this, 'flatFiles'])
            ->flatten();

        return [
            'method' => strtoupper($request->getMethod()),
            'uri' => $request->getPathInfo(),
            'body' => $request->except(config('http-logger.except')),
            'headers' => $this->getSanitizer()->clean($request->headers->all(), config('http-logger.sanitize_headers')),
            'files' => $files,
        ];
    }

    protected function formatMessage(array $message): string
    {
        try {
            $bodyAsJson = json_encode($message['body'], JSON_THROW_ON_ERROR);
            $headersAsJson = json_encode($message['headers'], JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return "{$message['method']} {$message['uri']}";
        }

        $files = $message['files']->implode(',');

        return "{$message['method']} {$message['uri']} - Body: {$bodyAsJson} - Headers: {$headersAsJson} - Files: ".$files;
    }

    public function flatFiles($file): array|string
    {
        if ($file instanceof UploadedFile) {
            return $file->getClientOriginalName();
        }
        if (is_array($file)) {
            return array_map([$this, 'flatFiles'], $file);
        }

        return (string) $file;
    }

    protected function getSanitizer(): Sanitizer
    {
        if (! $this->sanitizer instanceof Sanitizer) {
            $this->sanitizer = new Sanitizer();
        }

        return $this->sanitizer;
    }
}
