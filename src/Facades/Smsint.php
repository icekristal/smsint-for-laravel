<?php

namespace Facades;

use Illuminate\Support\Facades\Facade;

class Smsint extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'ice.smsint';
    }
}
