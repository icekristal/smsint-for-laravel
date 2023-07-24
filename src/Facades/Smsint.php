<?php

namespace Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Services\Smsint\InitParams setMessage(string $message)
 * @method static \Services\Smsint\InitParams setSenderName(string $senderName)
 * @method static \Services\Smsint\InitParams setRecipients(array $recipients)
 * @method static \Services\Smsint\InitParams setParams(array $params)
 * @method static \Services\IceSmsintService sendSms()
 */
class Smsint extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'ice.smsint';
    }
}
