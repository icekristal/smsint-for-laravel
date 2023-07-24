<?php

namespace Services\Smsint;

class Sms extends InitParams
{
    protected string $partUrl = "/sms";

    public function sendMessage(): void
    {
        $this->partUrl .= "/send/text";
        $this->send();
    }
}
