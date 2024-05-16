<?php

namespace SMSkin\LaravelOpenAi\Models;

use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;
use SMSkin\LaravelOpenAi\Enums\RoleEnum;

class ChatMessage
{
    /**
     * @param RoleEnum $role
     * @param string $content
     * @param Collection<Attachment>|null $attachments
     */
    public function __construct(
        public readonly RoleEnum $role,
        public readonly string $content,
        public readonly Collection|null $attachments = null
    ) {
    }

    #[ArrayShape(['role' => 'string', 'content' => 'string', 'attachments' => 'array'])]
    public function toArray(): array
    {
        $data = [
            'role' => $this->role->value,
            'content' => $this->content,
        ];
        if (filled($this->attachments)) {
            $data['attachments'] = $this->attachments?->map(static function (Attachment $attachment) {
                return $attachment->toArray();
            })->toArray();
        }

        return $data;
    }
}
