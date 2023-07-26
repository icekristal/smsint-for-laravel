<?php

namespace Icekristal\SmsintForLaravel\Services\Smsint;

use Icekristal\SmsintForLaravel\Enums\SmsintTypeEnum;
use GuzzleHttp\Promise\PromiseInterface;
use Icekristal\SmsintForLaravel\Models\SmsIntOwner;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Icekristal\SmsintForLaravel\Interface\SmsIntOperationInterface;
use Icekristal\SmsintForLaravel\Models\SmsInt;

class InitParams implements SmsIntOperationInterface
{

    private string $message;

    private bool $isSaveDb = false;

    private ?string $senderName = null;
    private array $recipients = [];
    private array $params = [];
    private array $response = [];
    private string $typeService = 'sms';

    protected string $partUrl = '';

    public function __construct()
    {
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;
        return $this;
    }

    public function setSenderName(?string $senderName): static
    {
        $this->senderName = $senderName;
        return $this;
    }

    public function setRecipients(array $recipients): static
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
    public function setTypeService(string $typeService): static
    {
        $this->typeService = $typeService;
        return $this;
    }

    /**
     * @param array $allParams
     * @return array
     */
    public static function initTotalParams(array $allParams): array
    {
        $arraySend['validate'] = $allParams['is_only_validate'] ?? false;
        $arraySend['tags'] = $allParams['tags'] ?? [];
        $arraySend['startDateTime'] = $allParams['startDateTime'] ?? now()->format('Y-m-d H:i:s');

        if (isset($allParams['timeRange'])) {
            $arraySend['timeRange'] = $allParams['timeRange'];
        }

        if (isset($allParams['smooth'])) {
            $arraySend['smooth'] = $allParams['smooth'];
        }

        if (isset($allParams['timeZone'])) {
            $arraySend['timeZone'] = $allParams['timeZone'];
        }

        if (isset($allParams['duplicateRecipientsAllowed'])) {
            $arraySend['duplicateRecipientsAllowed'] = $allParams['duplicateRecipientsAllowed'];
        }

        if (isset($allParams['opsosAllowed'])) {
            $arraySend['opsosAllowed'] = $allParams['opsosAllowed'];
        }

        if (isset($allParams['opsosDisallowed'])) {
            $arraySend['opsosDisallowed'] = $allParams['opsosDisallowed'];
        }

        return $arraySend;
    }

    public function send(): PromiseInterface|Response
    {
        $sendParams = $this->getParams();
        $fullUrl = config('services.smsint.url', 'https://lcab.smsint.ru/json/') . config('services.smsint.version', 'v1.0') . $this->partUrl;

        if ($this->isSaveDb) {
            try {
                $smsInt = SmsInt::query()->create([
                    'recipients' => $this->getRecipients(),
                    'type' => $this->getTypeService(),
                    'cascade_id' => $this->getParams()['schemeId'] ?? null,
                    'message' => $this->getParams()['text'] ?? '',
                    'is_validate' => $this->getParams()['is_only_validate'] ?? $this->getParams()['validate'] ?? false,
                    'is_send' => false,
                    'send_url' => $fullUrl,
                    'name_send' => $this->getParams()['source'] ?? '',
                    'start_send_at' => $this->getParams()['startDateTime'] ?? now(),
                    'info_send' => $sendParams ?? []
                ]);

                foreach ($sendParams['messages'] as &$message) {
                    $message['id'] = "{$smsInt->id}";
                    if (!is_array(config('smsint.list_model_search_owner'))) continue;
                    foreach (config('smsint.list_model_search_owner') as $classSearchOwner => $fieldsSearchOwner) {
                        if (!is_array($fieldsSearchOwner)) continue;
                        foreach ($fieldsSearchOwner as $fieldSearchOwner) {
                            $resultOwner = $classSearchOwner::query()->where($fieldSearchOwner, $message['recipient'])->first();
                            if (!is_null($resultOwner)) {
                                SmsIntOwner::query()->create([
                                    'smsint_id' => $smsInt->id,
                                    'recipient' => $message['recipient'] ?? null,
                                    'owner_type' => $classSearchOwner ?? null,
                                    'owner_id' => $resultOwner->id ?? null,
                                    'info' => $message ?? []
                                ]);
                            }
                        }

                    }
                }
            } catch (\Exception $exception) {
                Log::error($exception);
            }
        }


        $result = Http::acceptJson()
            ->withHeaders([
                'X-Token' => config('services.smsint.token'),
            ])
            ->timeout(15)
            ->post($fullUrl, $sendParams);

        //Save in DB and return response
        if ($this->isSaveDb) {
            try {
                $isSend = false;
                $price = 0;
                if ($result->status() == 200) {
                    $isSend = true;
                    $price = $result?->body()?->result?->price?->sum ?? 0;
                }

                if (isset($smsInt) && !is_null($smsInt)) {
                    $smsInt->update([
                        'price' => $price,
                        'is_send' => $isSend,
                        'info_answer' => $result?->body(),
                    ]);
                }


            } catch (\Exception $exception) {
                Log::error($exception);
            }
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function isSaveDb(): bool
    {
        return $this->isSaveDb;
    }

    /**
     * @param bool $isSaveDb
     */
    public function setIsSaveDb(bool $isSaveDb): void
    {
        $this->isSaveDb = $isSaveDb;
    }
}
