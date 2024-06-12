<?php

namespace core\utils;

use Throwable;

class debugger
{
    private array $logs = [];
    public function __construct(protected bool $debug = false)
    {
        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
        register_shutdown_function([$this, 'handleShutdown']);
    }

    public function log(string $type,  string $message): void
    {
        if ($this->debug) {
            $this->logs[$type][] = [
                'message' => $message,
                'time' => time(),
                'memory_usage' => memory_get_usage()
            ];
        }
    }

    public function handleError(int $errno, string $errstr, string $errfile, int $errline): void
    {
        $this->renderError('Error', $errstr, $errfile, $errline);
    }

    public function handleException(Throwable $exception): void
    {
        $this->renderError(
            'Exception',
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTrace()
        );
        exit(0);
    }

    public function handleShutdown(): void
    {
        $error = error_get_last();
        if ($error !== null) {
            $this->renderError('Shutdown Error', $error['message'], $error['file'], $error['line']);
        }
    }

    private function renderError(string $type, string $message, string $file, int $line, array $trace = []): void
    {
        if (!headers_sent()) {
            http_response_code(500);
        }
        if (!$this->debug) {
            $this->renderNotice($message, $file, $line);
            exit(0);
        }
        $traceHtml = $this->formatTrace($trace);
        echo <<<HTML
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>{$type}: {$message}</title>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0; }
                    .container { padding: 20px; }
                    .error-box { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 20px; }
                    .trace-box { background-color: #f1f1f1; padding: 10px; border: 1px solid #ccc; margin-top: 10px; margin-top: 20px; }
                    .trace-box pre { margin: 0; }
                    h1 { font-size: 24px; margin: 0 0 10px; }
                    p { margin: 0 0 10px; }
                    .file { font-weight: bold; }
                    .line { font-weight: bold; color: #d9534f; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="error-box">
                        <h1>{$type}: {$message}</h1>
                        <p><span class="file">{$file}</span> at line <span class="line">{$line}</span></p>
                    </div>
                    {$traceHtml}
                </div>
            </body>
            </html>
        HTML;
    }

    private function renderNotice(string $message, string $file, int $line): void
    {
        echo <<<HTML
            <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Oops: There is a Error!</title>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0; }
                        .container { padding: 20px; max-width: 960px;margin:auto; text-align:center; }
                        .error-box { background-color: #fefce8; color: #ca8a04; border: 1px solid #fef08a; padding: 20px; }
                        h1 { font-size: 28px; margin: 0 0 10px; }
                        p { margin: 0 0 10px; font-size:16px; }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="error-box">
                            <h1>Oops!!</h1>
                            <p>{$message} in <b>{$file}</b> on line <b>{$line}</b></p><p>There has been a critical error on this website.</p>
                        </div>
                    </div>
                </body>
            </html>
        HTML;
    }

    private function formatTrace(array $trace): string
    {
        $traceHtml = '';
        foreach ($trace as $index => $frame) {
            $file = $frame['file'] ?? '[internal function]';
            $line = $frame['line'] ?? '';
            $function = $frame['function'] ?? '';
            $class = $frame['class'] ?? '';
            $type = $frame['type'] ?? '';
            $args = isset($frame['args']) ? $this->formatArgs($frame['args']) : '';
            $traceHtml .= "#{$index} {$file}({$line}): {$class}{$type}{$function}({$args})\n";
        }
        if (!empty($traceHtml)) {
            $traceHtml = htmlspecialchars($traceHtml, ENT_QUOTES, 'UTF-8');
            $traceHtml = <<<HTML
                <div class="trace-box">
                    <h2>Stack Trace</h2>
                    <pre>{$traceHtml}</pre>
                </div>
            HTML;
        }
        return $traceHtml;
    }

    private function formatArgs(array $args): string
    {
        return implode(', ', array_map(fn ($arg) => is_object($arg) ? get_class($arg) : gettype($arg), $args));
    }

    public function __destruct()
    {
        if ($this->debug && $_SERVER['REQUEST_METHOD'] === 'GET') {
            // render debugger
            echo 'Hello From Debugger..';
        }
    }
}
