<?php

namespace SMSkin\LaravelOpenAi\Models;

class RetrievalTool extends BaseTool
{
    public readonly string $type;

    public function __construct()
    {
        $this->type = 'retrieval';
    }
}
