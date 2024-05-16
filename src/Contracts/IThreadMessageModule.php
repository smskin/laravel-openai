<?php

namespace SMSkin\LaravelOpenAi\Contracts;

use Illuminate\Support\Collection;
use OpenAI\Responses\Threads\Messages\Files\ThreadMessageFileListResponse;
use OpenAI\Responses\Threads\Messages\ThreadMessageResponse;
use SMSkin\LaravelOpenAi\Enums\RoleEnum;
use SMSkin\LaravelOpenAi\Exceptions\MessageNotFound;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Models\MetaData;

interface IThreadMessageModule
{
    /**
     * @throws ThreadNotFound
     */
    public function create(
        string $threadId,
        RoleEnum $role,
        string $content,
        Collection|null $attachments = null
    ): ThreadMessageResponse;

    /**
     * @throws MessageNotFound
     * @throws ThreadNotFound
     */
    public function retrieve(
        string $threadId,
        string $messageId
    ): ThreadMessageResponse;

    /**
     * @throws MessageNotFound
     * @throws ThreadNotFound
     */
    public function modify(
        string $threadId,
        string $messageId,
        MetaData|null $metaData = null
    ): ThreadMessageResponse;

    /**
     * @throws MessageNotFound
     * @throws ThreadNotFound
     */
    public function listFiles(
        string $threadId,
        string $messageId,
        int|null $limit = null
    ): ThreadMessageFileListResponse;
}
