<?php

namespace SMSkin\LaravelOpenAi\Providers;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->registerConfigs();
    }

    public function register()
    {
        $this->mergeConfigs();
    }
    private function registerConfigs()
    {
        $this->publishes([
            __DIR__ . '/../../config/openai.php' => $this->app->configPath('openai.php'),
        ], 'config');
    }

    private function mergeConfigs()
    {
        $configPath = __DIR__ . '/../../config/openai.php';
        $this->mergeConfigFrom($configPath, 'openai');
    }
}
