<?php

namespace SMSkin\LaravelOpenAi\Models;

class MessageContentPartImageUrl extends MessageContentPart
{
    public function __construct(
        public string      $url,
        public string|null $detail = null
    ) {
        $this->type = 'image_url';
    }

    public function toArray(): array
    {
        $payload = [
            'url' => $this->url,
        ];
        if ($this->detail) {
            $payload['detail'] = $this->detail;
        }

        return array_merge(
            parent::toArray(),
            [
                'image_url' => $payload,
            ]
        );
    }
}
