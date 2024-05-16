<?php

namespace SMSkin\LaravelOpenAi;

use Illuminate\Support\Collection;
use OpenAI\Responses\Threads\Messages\Files\ThreadMessageFileListResponse;
use OpenAI\Responses\Threads\Messages\ThreadMessageResponse;
use SMSkin\LaravelOpenAi\Contracts\IThreadMessageModule;
use SMSkin\LaravelOpenAi\Controllers\ThreadMessage\Create;
use SMSkin\LaravelOpenAi\Controllers\ThreadMessage\ListFiles;
use SMSkin\LaravelOpenAi\Controllers\ThreadMessage\Modify;
use SMSkin\LaravelOpenAi\Controllers\ThreadMessage\Retrieve;
use SMSkin\LaravelOpenAi\Enums\RoleEnum;
use SMSkin\LaravelOpenAi\Exceptions\MessageNotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Models\MetaData;

class ThreadMessageModule implements IThreadMessageModule
{
    /**
     * @throws ThreadNotFound
     */
    public function create(
        string          $threadId,
        RoleEnum        $role,
        string          $content,
        Collection|null $attachments = null
    ): ThreadMessageResponse {
        return (new Create($threadId, $role, $content, $attachments))->execute();
    }

    /**
     * @throws MessageNotFound
     * @throws ThreadNotFound
     */
    public function retrieve(
        string $threadId,
        string $messageId
    ): ThreadMessageResponse {
        return (new Retrieve($threadId, $messageId))->execute();
    }

    /**
     * @throws MessageNotFound
     * @throws ThreadNotFound
     */
    public function modify(
        string        $threadId,
        string        $messageId,
        MetaData|null $metaData = null
    ): ThreadMessageResponse {
        return (new Modify($threadId, $messageId, $metaData))->execute();
    }

    /**
     * @throws MessageNotFound
     * @throws ThreadNotFound
     */
    public function listFiles(
        string   $threadId,
        string   $messageId,
        int|null $limit = null
    ): ThreadMessageFileListResponse {
        $limit ??= 10;
        return (new ListFiles($threadId, $messageId, $limit))->execute();
    }
}
