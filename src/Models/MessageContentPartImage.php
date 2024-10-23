<?php

namespace SMSkin\LaravelOpenAi\Models;

class MessageContentPartImage extends MessageContentPart
{
    public function __construct(
        public string      $fileId,
        public string|null $detail = null
    ) {
        $this->type = 'image_file';
    }

    public function toArray(): array
    {
        $payload = [
            'file_id' => $this->fileId,
        ];
        if ($this->detail) {
            $payload['detail'] = $this->detail;
        }

        return array_merge(
            parent::toArray(),
            [
                'image_file' => $payload,
            ]
        );
    }
}
