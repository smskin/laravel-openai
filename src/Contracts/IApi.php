<?php

namespace SMSkin\LaravelOpenAi\Contracts;

interface IApi
{
    public function threads(): IThreadModule;

    public function images(): IImageModule;

    public function completions(): ICompletionModule;

    public function chats(): IChatModule;

    public function audios(): IAudioModule;

    public function assistants(): IAssistantModule;
}
