<?php

namespace SMSkin\LaravelOpenAi\Providers;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Facades\Config;
use OpenAI;
use OpenAI\Contracts\ClientContract;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SMSkin\LaravelOpenAi\Api;
use SMSkin\LaravelOpenAi\AssistantFileModule;
use SMSkin\LaravelOpenAi\AssistantModule;
use SMSkin\LaravelOpenAi\AudioModule;
use SMSkin\LaravelOpenAi\ChatModule;
use SMSkin\LaravelOpenAi\CompletionModule;
use SMSkin\LaravelOpenAi\Contracts\IApi;
use SMSkin\LaravelOpenAi\Contracts\IAssistantFileModule;
use SMSkin\LaravelOpenAi\Contracts\IAssistantModule;
use SMSkin\LaravelOpenAi\Contracts\IAudioModule;
use SMSkin\LaravelOpenAi\Contracts\IChatModule;
use SMSkin\LaravelOpenAi\Contracts\ICompletionModule;
use SMSkin\LaravelOpenAi\Contracts\IImageModule;
use SMSkin\LaravelOpenAi\Contracts\IThreadMessageFileModule;
use SMSkin\LaravelOpenAi\Contracts\IThreadMessageModule;
use SMSkin\LaravelOpenAi\Contracts\IThreadModule;
use SMSkin\LaravelOpenAi\Contracts\IThreadRunModule;
use SMSkin\LaravelOpenAi\ImageModule;
use SMSkin\LaravelOpenAi\ThreadMessageFileModule;
use SMSkin\LaravelOpenAi\ThreadMessageModule;
use SMSkin\LaravelOpenAi\ThreadModule;
use SMSkin\LaravelOpenAi\ThreadRunModule;

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
        $this->app->singleton(IApi::class, static function () {
            return new Api();
        });
        $this->app->singleton(IThreadModule::class, static function () {
            return new ThreadModule();
        });
        $this->app->singleton(IThreadRunModule::class, static function () {
            return new ThreadRunModule();
        });
        $this->app->singleton(IThreadMessageModule::class, static function () {
            return new ThreadMessageModule();
        });
        $this->app->singleton(IThreadMessageFileModule::class, static function () {
            return new ThreadMessageFileModule();
        });
        $this->app->singleton(IImageModule::class, static function () {
            return new ImageModule();
        });
        $this->app->singleton(ICompletionModule::class, static function () {
            return new CompletionModule();
        });
        $this->app->singleton(IChatModule::class, static function () {
            return new ChatModule();
        });
        $this->app->singleton(IAudioModule::class, static function () {
            return new AudioModule();
        });
        $this->app->singleton(IAssistantModule::class, static function () {
            return new AssistantModule();
        });
        $this->app->singleton(IAssistantFileModule::class, static function () {
            return new AssistantFileModule();
        });
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
