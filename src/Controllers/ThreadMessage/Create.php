<?php

namespace SMSkin\LaravelOpenAi\Controllers\ThreadMessage;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Threads\Messages\ThreadMessageResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\RoleEnum;
use SMSkin\LaravelOpenAi\Exceptions\ThreadNotFound;
use SMSkin\LaravelOpenAi\Models\Attachment;

class Create extends BaseController
{
    /**
     * @param string $threadId
     * @param RoleEnum $role
     * @param string $content
     * @param Collection<Attachment>|null $attachments
     */
    public function __construct(
        private readonly string $threadId,
        private readonly RoleEnum $role,
        private readonly string $content,
        private readonly Collection|null $attachments
    ) {
    }

    /**
     * @throws ThreadNotFound
     */
    public function execute(): ThreadMessageResponse
    {
        try {
            return $this->getClient()->threads()->messages()->create($this->threadId, [
                'role' => $this->role->value,
                'content' => $this->content,
                'attachments' => $this->attachments->map(static function (Attachment $attachment) {
                    return $attachment->toArray();
                }),
            ]);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'No thread found with id')) {
                throw new ThreadNotFound($exception->getMessage(), 500, $exception);
            }

            $this->errorExceptionHandler($exception);
        }
    }
}
