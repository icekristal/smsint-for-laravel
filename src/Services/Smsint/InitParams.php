<?php

namespace Services\Smsint;

use Enums\SmsintTypeEnum;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Interface\SmsIntOperationInterface;

class InitParams implements SmsIntOperationInterface
{

    private string $message;
    private ?string $senderName = null;
    private array $recipients = [];
    private array $params = [];
    private array $response = [];
    private string $typeService = 'sms';

    protected string $partUrl = '';

    public function __construct()
    {
    }

    public function setMessage(string $message): SmsIntOperationInterface
    {
        $this->message = $message;
        return $this;
    }

    public function setSenderName(string $senderName): SmsIntOperationInterface
    {
        $this->senderName = $senderName;
        return $this;
    }

    public function setRecipients(array $recipients): SmsIntOperationInterface
    {
        $this->recipients = $recipients;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string|null
     */
    public function getSenderName(): ?string
    {
        return $this->senderName;
    }

    /**
     * @return array
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    public function setParams(array $params): SmsIntOperationInterface
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
     * @return array
     */
    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * @param $response
     */
    public function setResponse($response): void
    {
        $this->response = $response;
    }



    /**
     * @return string
     */
    public function getTypeService(): string
    {
        return $this->typeService;
    }

    /**
     * @param string $typeService
     * @return InitParams
     */
    public function setTypeService(string $typeService): InitParams
    {
        $this->typeService = $typeService;
        return $this;
    }


    public function send()
    {
        $fullUrl = config('services.smsint.url', 'https://lcab.smsint.ru/json/') . config('services.smsint.version', 'v1.0') . $this->partUrl;
        $result =  Http::acceptJson()
            ->withHeaders([
                'X-Token' => config('services.smsint.token'),
            ])
            ->timeout(15)
            ->post($fullUrl, $this->getParams());

        //Save in DB and return response

        return $result;
    }
}
