<?php

namespace SMSkin\LaravelOpenAi;

class OpenAi
{
    public function assistants(): Assistant
    {
        return new Assistant();
    }

    public function threads(): Thread
    {
        return new Thread();
    }

    public function files(): File
    {
        return new File();
    }
}
