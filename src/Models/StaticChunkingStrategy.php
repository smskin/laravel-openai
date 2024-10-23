<?php

namespace SMSkin\LaravelOpenAi\Models;

class StaticChunkingStrategy extends ChunkingStrategy
{
    public function __construct(
        public int $maxChunkSizeTokens,
        public int $chunkOverlapTokens
    ) {
        $this->type = 'static';
    }

    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'static' => [
                    'max_chunk_size_tokens' => $this->maxChunkSizeTokens,
                    'chunk_overlap_tokens' => $this->chunkOverlapTokens,
                ],
            ]
        );
    }
}
