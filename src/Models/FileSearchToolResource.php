<?php

namespace SMSkin\LaravelOpenAi\Models;

use Illuminate\Contracts\Support\Arrayable;

class FileSearchToolResource implements Arrayable
{
    public function __construct(
        public array|null            $vectorStoreIds = null,
        public array|null            $fileIds = null,
        public ChunkingStrategy|null $chunkingStrategy = null,
        public array|null            $metadata = null,
    ) {
    }

    public function toArray(): array
    {
        $payload = [];
        if ($this->vectorStoreIds) {
            $payload['vector_store_ids'] = $this->vectorStoreIds;
        }
        if ($this->fileIds) {
            $payload['vector_stores']['file_ids'] = $this->fileIds;
        }
        if ($this->chunkingStrategy) {
            $payload['vector_stores']['chunking_strategy'] = $this->chunkingStrategy->toArray();
        }
        if ($this->metadata) {
            $payload['metadata'] = $this->metadata;
        }
        return $payload;
    }
}
