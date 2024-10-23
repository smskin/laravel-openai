<?php

namespace SMSkin\LaravelOpenAi\Models;

class MessageContentPartText extends MessageContentPart
{
    public function __construct(public string $text)
    {
        $this->type = 'text';
    }

    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'text' => $this->text,
            ]
        );
    }
}
