<?php

namespace SMSkin\LaravelOpenAi\Support\SerializesModels\Contracts;

use Throwable;

interface ISerializableException
{
    public function unSerialize(): Throwable;
}
