<?php

namespace SMSkin\LaravelOpenAi\Models;

class FunctionToolChoice extends ToolChoice
{
    public function __construct(public string $functionName)
    {
        $this->type = 'function';
    }

    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'function' => [
                    'name' => $this->functionName,
                ],
            ]
        );
    }
}
