<?php

namespace Icekristal\SmsintForLaravel\Services;

use Carbon\Carbon;

trait InitTrait
{


    private array $params = [];
    private ?string $message = null;
    private ?array $recipients = null;
    private ?string $senderName = null;
    private bool $isOnlyValid = false;

    private ?Carbon $startDateTime = null;

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return IceSmsintService
     */
    public function setMessage(?string $message): IceSmsintService
    {
        $this->message = $message;
        return $this;
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
        if (!is_null($this->getRecipients())) {
            $this->params['recipients'] = $this->getRecipients();
        }
        if (!is_null($this->getSenderName())) {
            $this->params['source'] = $this->getSenderName();
        } else {
            $this->params['source'] = config('smsint.default_sender_name', 'source');
        }
        if (!is_null($this->getMessage())) {
            $this->params['message'] = $this->getMessage();
        }

        $this->params['startDateTime'] = !is_null($this->getStartDateTime()) ? $this->getStartDateTime() : null;

        $this->params['is_only_validate'] = $this->getIsOnlyValid();
        return $this->params;
    }

    /**
     * @return array
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * @param array $recipients
     * @return IceSmsintService
     */
    public function setRecipients(array $recipients): IceSmsintService
    {
        $this->recipients = $recipients;
        return $this;
    }


    /**
     * @return string|null
     */
    public function getSenderName(): ?string
    {
        return $this->senderName;
    }

    /**
     * @param string|null $senderName
     * @return IceSmsintService
     */
    public function setSenderName(?string $senderName): IceSmsintService
    {
        $this->senderName = $senderName;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsOnlyValid(): bool
    {
        return $this->isOnlyValid;
    }

    /**
     * @param bool $isOnlyValid
     * @return IceSmsintService
     */
    public function setIsOnlyValid(bool $isOnlyValid): IceSmsintService
    {
        $this->isOnlyValid = $isOnlyValid;
        return $this;
    }

    /**
     * @return Carbon|string|null
     */
    public function getStartDateTime(): Carbon|string|null
    {
        return $this->startDateTime?->format('Y-m-d H:i:s');
    }

    /**
     * @param Carbon|null $startDateTime
     * @return IceSmsintService
     */
    public function setStartDateTime(?Carbon $startDateTime): IceSmsintService
    {
        $this->startDateTime = $startDateTime;
        return $this;
    }

}
