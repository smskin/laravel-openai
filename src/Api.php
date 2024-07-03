<?php

namespace SMSkin\LaravelOpenAi;

use SMSkin\LaravelOpenAi\Contracts\IApi;
use SMSkin\LaravelOpenAi\Contracts\IAssistantModule;
use SMSkin\LaravelOpenAi\Contracts\IAudioModule;
use SMSkin\LaravelOpenAi\Contracts\IChatModule;
use SMSkin\LaravelOpenAi\Contracts\ICompletionModule;
use SMSkin\LaravelOpenAi\Contracts\IFileModule;
use SMSkin\LaravelOpenAi\Contracts\IImageModule;
use SMSkin\LaravelOpenAi\Contracts\IThreadModule;

class Api implements IApi
{
    public function threads(): IThreadModule
    {
        return app(IThreadModule::class);
    }

    public function images(): IImageModule
    {
        return app(IImageModule::class);
    }

    public function completions(): ICompletionModule
    {
        return app(ICompletionModule::class);
    }

    public function chats(): IChatModule
    {
        return app(IChatModule::class);
    }

    public function audios(): IAudioModule
    {
        return app(IAudioModule::class);
    }

    public function assistants(): IAssistantModule
    {
        return app(IAssistantModule::class);
    }

    public function files(): IFileModule
    {
        return app(IFileModule::class);
    }
}
