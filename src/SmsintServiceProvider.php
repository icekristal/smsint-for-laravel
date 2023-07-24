<?php

use Illuminate\Support\ServiceProvider;
use Services\IceSmsintService;

class SmsintServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind('ice.smsint', IceSmsintService::class);
        $this->registerConfig();
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishConfigs();
            $this->publishMigrations();
        }
    }

    protected function registerConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/smsint.php', 'smsint');
    }


    protected function publishMigrations(): void
    {
        if (!class_exists('CreateSmsintTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_smsint_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_smsint_table.php'),
            ], 'migrations');
        }
        if (!class_exists('CreateSmsintOwnerTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_smsint_owner_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_smsint_owner_table.php'),
            ], 'migrations');
        }
    }

    protected function publishConfigs(): void
    {
        $this->publishes([
            __DIR__ . '/../config/smsint.php' => config_path('smsint.php'),
        ], 'config');
    }

}
