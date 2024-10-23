<?php

namespace SMSkin\LaravelOpenAi\Models;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class Thread implements Arrayable
{
    /**
     * @param Collection<Message>|null $messages
     * @param CodeInterpreterToolResource|null $codeInterpreterToolResource
     * @param FileSearchToolResource|null $fileSearchToolResource
     * @param array|null $metadata
     */
    public function __construct(
        public readonly Collection|null $messages = null,
        private readonly CodeInterpreterToolResource|null $codeInterpreterToolResource = null,
        private readonly FileSearchToolResource|null $fileSearchToolResource = null,
        private readonly array|null $metadata = null,
    ) {
    }

    public function toArray(): array
    {
        $payload = [];
        if ($this->messages !== null) {
            $payload['messages'] = $this->messages->map(static function (Message $message) {
                return $message->toArray();
            });
        }
        if ($this->codeInterpreterToolResource) {
            $payload['tool_resources']['code_interpreter'] = $this->codeInterpreterToolResource->toArray();
        }
        if ($this->fileSearchToolResource) {
            $payload['tool_resources']['file_search'] = $this->fileSearchToolResource->toArray();
        }
        if ($this->metadata) {
            $payload['metadata'] = $this->metadata;
        }
        return $payload;
    }
}
