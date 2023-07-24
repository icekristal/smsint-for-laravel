<?php

namespace Services;


use Services\Smsint\Sms;

class IceSmsintService
{

    private array $params = [];

    private string $recipient = '';
    private string $senderName = '';

    //https://lcab.smsint.ru/cabinet/json-doc/sender#section/Vvedenie
    public function __construct()
    {

    }

    public function setParams(array $params): static
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }


    /**
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }

    /**
     * @param string $recipient
     * @return IceSmsintService
     */
    public function setRecipient(string $recipient): IceSmsintService
    {
        $this->recipient = $recipient;
        return $this;
    }



    /**
     * @return string
     */
    public function getSenderName(): string
    {
        return $this->senderName;
    }

    /**
     * @param string $senderName
     * @return IceSmsintService
     */
    public function setSenderName(string $senderName): IceSmsintService
    {
        $this->senderName = $senderName;
        return $this;
    }

    /**
     * @return void
     */
    public function sendSms(): void
    {
        (new Sms())
            ->setSenderName($this->getSenderName())
            ->setRecipient($this->getRecipient())
            ->setParams($this->getParams())
            ->sendMessage();
    }


}
