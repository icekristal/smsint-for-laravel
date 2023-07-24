<?php

namespace Services\Smsint;

use Enums\SmsintTypeEnum;

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
        $arraySend = [];
        $messages = [];
        foreach ($this->getRecipients() as $recipient) {
            $messages[] = [
                'recipient' => $recipient,
                'recipientType' => $this->getParams()['recipientType'] ?? 'recipient',
                'source' => $this->getParams()['source'] ?? 'source',
                'timeout' => $this->getParams()['timeout'] ?? 3600,
                'shortenUrl' => $this->getParams()['shortenUrl'] ?? true,
                'text' => $this->getMessage(),
            ];
        }

        $arraySend['messages'] = $messages;
        $arraySend['validate'] = $this->getParams()['is_only_validate'] ?? false;
        $arraySend['tags'] = $this->getParams()['tags'] ?? [];
        $arraySend['startDateTime'] = $this->getParams()['startDateTime'] ?? now()->format('Y-m-d H:i:s');

        if(isset($this->getParams()['timeRange'])) {
            $arraySend['timeRange'] = $this->getParams()['timeRange'];
        }

        if(isset($this->getParams()['smooth'])) {
            $arraySend['smooth'] = $this->getParams()['smooth'];
        }

        if(isset($this->getParams()['timeZone'])) {
            $arraySend['timeZone'] = $this->getParams()['timeZone'];
        }

        if(isset($this->getParams()['duplicateRecipientsAllowed'])) {
            $arraySend['duplicateRecipientsAllowed'] = $this->getParams()['duplicateRecipientsAllowed'];
        }

        if(isset($this->getParams()['opsosAllowed'])) {
            $arraySend['opsosAllowed'] = $this->getParams()['opsosAllowed'];
        }

        if(isset($this->getParams()['opsosDisallowed'])) {
            $arraySend['opsosDisallowed'] = $this->getParams()['opsosDisallowed'];
        }

        $arraySend['channel'] = $this->getParams()['channel'] ?? 0;
        $arraySend['transliterate'] = $this->getParams()['transliterate'] ?? false;

        $this->setParams($arraySend);
        $this->send();
    }
}
