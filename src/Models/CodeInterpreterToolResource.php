<?php

namespace SMSkin\LaravelOpenAi\Models;

use Illuminate\Contracts\Support\Arrayable;

class CodeInterpreterToolResource implements Arrayable
{
    public function __construct(
        public array $fileIds
    ) {
    }

    public function toArray(): array
    {
        return [
            'file_ids' => $this->fileIds,
        ];
    }
}
