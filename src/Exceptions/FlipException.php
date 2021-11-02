<?php

namespace Kangyasin\LaravelFlip\Exceptions;

use Exception;
use Kangyasin\LaravelFlip\Helpers\FlipResponseHelper;
use Illuminate\Http\JsonResponse;
use Throwable;
use Kangyasin\LaravelFlip\Traits\ChannelLogging;

Class FlipException extends Exception
{
    use ChannelLogging;

    /**
     * UnhandledException constructor.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct($message = '', int $code = 0)
    {
        $this->message = json_decode($message, true);
        parent::__construct($message, $code);
    }

    /**
     * Report exception
     */
    public function report()
    {
        $messages = ' Unhandled Exception Message: ' . $this->getMessage() .
            ' File: ' . $this->getFile() .
            ' Line: ' . $this->getLine() .
            ' Exception Message: ' . $this->getMessage() .
            ' Exception File: ' . $this->getFile() .
            ' Exception Line: ' . $this->getLine();
        \Log::alert($messages);
    }

    /**
     * @param $request
     * @return JsonResponse
     */
    public function render($request)
    {

        return FlipResponseHelper::json(false, 500, json_decode($this->getMessage(), true));
    }

}
