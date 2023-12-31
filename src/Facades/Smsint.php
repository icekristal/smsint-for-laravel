<?php

namespace Icekristal\SmsintForLaravel\Facades;

use Illuminate\Support\Facades\Facade;
use Icekristal\SmsintForLaravel\Services\IceSmsintService;

/**
 * @method static \Icekristal\SmsintForLaravel\Services\Smsint\InitParams setMessage(string $message)
 * @method static \Icekristal\SmsintForLaravel\Services\Smsint\InitParams setSenderName(string $senderName)
 * @method static \Icekristal\SmsintForLaravel\Services\Smsint\InitParams setRecipients(array $recipients)
 * @method static \Icekristal\SmsintForLaravel\Services\Smsint\InitParams setParams(array $params)
 * @method static IceSmsintService sendSms()
 * @method static IceSmsintService getSmsStatus(array $listMessagesIds)
 * @method static \Icekristal\SmsintForLaravel\Services\Smsint\InitParams setIsOnlyValid()
 * @method static \Icekristal\SmsintForLaravel\Services\Smsint\InitParams setIsSaveDb(bool $isSaveDb)
 */
class Smsint extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'ice.smsint';
    }
}
