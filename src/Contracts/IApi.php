<?php

namespace SMSkin\LaravelOpenAi\Contracts;

interface IApi
{
    public function thread(): IThreadModule;

    public function threadRun(): IThreadRunModule;

    public function threadMessage(): IThreadMessageModule;

    public function threadMessageFile(): IThreadMessageFileModule;

    public function image(): IImageModule;

    public function completion(): ICompletionModule;

    public function chat(): IChatModule;

    public function audio(): IAudioModule;

    public function assistant(): IAssistantModule;

    public function assistantFile(): IAssistantFileModule;
}
