<?php

namespace SMSkin\LaravelOpenAi\Models;

class CodeInterpreterTool extends BaseTool
{
    public readonly string $type;

    public function __construct()
    {
        $this->type = 'code_interpreter';
    }
}
