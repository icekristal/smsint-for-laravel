<?php

namespace Services\Smsint;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Interface\SmsIntOperationInterface;

class InitParams implements SmsIntOperationInterface
{

    private string $message;
    private ?string $senderName = null;
    private string $recipient;
    private array $params = [];
    private array $response = [];

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

    public function setRecipient(string $recipient): SmsIntOperationInterface
    {
        $this->recipient = $recipient;
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
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function setParams(array $params): SmsIntOperationInterface
    {
        $this->params = $params;
        return $this;
    }

    public function send(): PromiseInterface|Response
    {
        $fullUrl = config('services.smsint.url', 'https://lcab.smsint.ru/json/') . config('services.smsint.version', 'v1.0') . $this->partUrl;
        return Http::acceptJson()
            ->withHeaders([
                'X-Token' => config('services.smsint.token'),
            ])
            ->timeout(15)
            ->post($fullUrl, $this->getParams());
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
}
