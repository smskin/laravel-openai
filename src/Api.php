<?php

namespace SMSkin\LaravelOpenAi;

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

class Api implements IApi
{
    public function thread(): IThreadModule
    {
        return app(IThreadModule::class);
    }

    public function threadRun(): IThreadRunModule
    {
        return app(IThreadRunModule::class);
    }

    public function threadMessage(): IThreadMessageModule
    {
        return app(IThreadMessageModule::class);
    }

    public function threadMessageFile(): IThreadMessageFileModule
    {
        return app(IThreadMessageFileModule::class);
    }

    public function image(): IImageModule
    {
        return app(IImageModule::class);
    }

    public function completion(): ICompletionModule
    {
        return app(ICompletionModule::class);
    }

    public function chat(): IChatModule
    {
        return app(IChatModule::class);
    }

    public function audio(): IAudioModule
    {
        return app(IAudioModule::class);
    }

    public function assistant(): IAssistantModule
    {
        return app(IAssistantModule::class);
    }

    public function assistantFile(): IAssistantFileModule
    {
        return app(IAssistantFileModule::class);
    }
}
