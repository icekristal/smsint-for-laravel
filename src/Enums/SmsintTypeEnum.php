<?php

namespace Icekristal\SmsintForLaravel\Enums;

enum SmsintTypeEnum: string
{
    case SMS = 'sms';
    case VIBER = 'viber';
    case WHATSAPP = 'whatsapp';
    case TELEGRAM = 'telegram';
    case VK = 'vk';
    case FACEBOOK = 'fb';
    case INSTAGRAM = 'instagram';
    case OK = 'ok';
    case TWITTER = 'twitter';
    case VOICE = 'voice';
    case CASCADE = 'cascade';

}
