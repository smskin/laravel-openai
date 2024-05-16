<?php

namespace SMSkin\LaravelOpenAi\Models;

use JetBrains\PhpStorm\ArrayShape;

class Attachment
{
    public function __construct(public readonly string $fileId)
    {
    }

    #[ArrayShape(['file_id' => 'string'])]
    public function toArray(): array
    {
        return ['file_id' => $this->fileId];
    }
}
