<?php

namespace SMSkin\LaravelOpenAi\Models;

use Illuminate\Contracts\Support\Arrayable;

class Attachment implements Arrayable
{
    public function __construct(
        public string|null $fileId,
        public bool|null   $codeInterpreterTool = null,
        public bool|null   $fileSearchTool = null,
    ) {
    }

    public function toArray(): array
    {
        $payload = [];
        if ($this->fileId) {
            $payload['file_id'] = $this->fileId;
        }
        if ($this->codeInterpreterTool) {
            $payload['tools'][] = [
                'type' => 'code_interpreter',
            ];
        }
        if ($this->fileSearchTool) {
            $payload['tools'][] = [
                'type' => 'file_search',
            ];
        }
        return $payload;
    }
}
