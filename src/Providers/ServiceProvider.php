<?php

namespace SMSkin\LaravelOpenAi\Providers;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Facades\Config;
use OpenAI;
use OpenAI\Contracts\ClientContract;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
        $this->mapModules();
        $this->mapApiClient();
    }

    private function mapModules()
    {
        foreach (Config::get('openai.mapper') as $interface => $class) {
            $this->app->singleton($interface, static function () use ($class) {
                return new $class();
            });
        }
    }

    private function mapApiClient()
    {
        $this->app->singleton(ClientContract::class, static function () {
            return OpenAI::factory()
                ->withApiKey(Config::get('openai.client.api_key'))
                ->withOrganization(Config::get('openai.client.organization')) // default: null
                ->withBaseUri(Config::get('openai.client.base_uri'))
                ->withHttpClient($client = new HttpClient([]))
                ->withHttpHeader('OpenAI-Beta', 'assistants=v1')
                ->withStreamHandler(static fn (RequestInterface $request): ResponseInterface => $client->send($request, [
                    'stream' => true,
                ]))
                ->make();
        });
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
