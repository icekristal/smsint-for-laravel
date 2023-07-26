<?php

namespace Icekristal\SmsintForLaravel\Services;


use Icekristal\SmsintForLaravel\Services\Smsint\Sms;

class IceSmsintService
{
    use InitTrait;

    //https://lcab.smsint.ru/cabinet/json-doc/sender#section/Vvedenie
    public function __construct()
    {

    }


    /**
     * @return void
     */
    public function sendSms(): void
    {
        (new Sms())
            ->setSenderName($this->getSenderName())
            ->setRecipients($this->getRecipients())
            ->setParams($this->getParams())
            ->sendMessage();
    }

    /**
     * @param array $listMessagesIds
     * @return void
     */
    public function getSmsStatus(array $listMessagesIds): void
    {
        (new Sms())->getStatus($listMessagesIds);
    }


}
