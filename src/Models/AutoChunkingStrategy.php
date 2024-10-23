<?php

namespace SMSkin\LaravelOpenAi\Models;

class AutoChunkingStrategy extends ChunkingStrategy
{
    public function __construct()
    {
        $this->type = 'auto';
    }
}
