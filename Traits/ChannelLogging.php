<?php
namespace Kangyasin\LaravelFlip\Traits;

trait ChannelLogging
{
    public $log;

    public function logger()
    {
        return \Log::channel('flip-log');

    }

    protected function resolveLogger()
    {

        $this->log = \Log::channel('flip-log');
    }
}
