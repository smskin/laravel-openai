<?php

namespace SMSkin\LaravelOpenAi\Models;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use SMSkin\LaravelOpenAi\Enums\RoleEnum;

class Message implements Arrayable
{
    /**
     * @param RoleEnum $role
     * @param string|Collection<MessageContentPart> $content
     * @param Collection<Attachment>|null $attachments
     * @param array|null $metadata
     */
    public function __construct(
        public RoleEnum          $role,
        public string|Collection $content,
        public Collection|null   $attachments = null,
        public array|null        $metadata = null
    ) {
    }

    public function toArray(): array
    {
        $payload = [
            'role' => $this->role->value,
        ];
        if ($this->content instanceof Collection) {
            $payload['content'] = $this->content->map(static function (MessageContentPart $part) {
                return $part->toArray();
            })->toArray();
        } else {
            $payload['content'] = $this->content;
        }
        if ($this->attachments) {
            $payload['attachments'] = $this->attachments->map(static function (Attachment $attachment) {
                return $attachment->toArray();
            })->toArray();
        }
        if ($this->metadata) {
            $payload['metadata'] = $this->metadata;
        }
        return $payload;
    }
}
