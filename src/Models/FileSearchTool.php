<?php

namespace SMSkin\LaravelOpenAi\Models;

class FileSearchTool extends BaseTool
{
    public readonly string $type;

    public function __construct()
    {
        $this->type = 'file_search';
    }
}
