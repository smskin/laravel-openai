<?php

namespace SMSkin\LaravelOpenAi\Models;

class Attachment
{
    public function __construct(public readonly string $fileId)
    {
    }

    public function toArray(): array
    {
        return ['file_id' => $this->fileId];
    }
}
