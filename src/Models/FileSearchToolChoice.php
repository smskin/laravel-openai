<?php

namespace SMSkin\LaravelOpenAi\Models;

class FileSearchToolChoice extends ToolChoice
{
    public function __construct()
    {
        $this->type = 'file_search';
    }
}
