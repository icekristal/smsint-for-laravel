<?php

namespace Icekristal\SmsintForLaravel\Services\Smsint;

use GuzzleHttp\Promise\PromiseInterface;
use Icekristal\SmsintForLaravel\Enums\SmsintTypeEnum;
use Illuminate\Http\Client\Response;

class Sms extends InitParams
{
    protected string $partUrl = "/sms";

    /**
     *
     */
    public function __construct()
    {
        $this->setTypeService(SmsintTypeEnum::SMS->value);
        parent::__construct();
    }

    public function sendMessage(): void
    {
        $this->partUrl .= "/send/text";
        $arraySend = self::initTotalParams($this->getParams());
        $this->setIsSaveDb(true);
        $messages = [];

        foreach ($this->getRecipients() as $recipient) {
            $messages[] = [
                'recipient' => $recipient,
                'recipientType' => $this->getParams()['recipientType'] ?? 'recipient',
                'source' => $this->getParams()['source'] ?? config('smsint.default_sender_name'),
                'timeout' => $this->getParams()['timeout'] ?? 3600,
                'shortenUrl' => $this->getParams()['shortenUrl'] ?? true,
                'text' => $this->getParams()['message'] ?? '-',
            ];
        }

        $arraySend['messages'] = $messages;
        $arraySend['channel'] = $this->getParams()['channel'] ?? 0;
        $arraySend['transliterate'] = $this->getParams()['transliterate'] ?? false;

        $this->setParams($arraySend);
        $this->send();
    }

    public function getStatus(array $listMessagesIds): PromiseInterface|Response
    {
        $this->partUrl .= "/status";
        $this->setParams($listMessagesIds);
        return $this->send();
    }
}
