<?php

namespace SMSkin\LaravelOpenAi\Controllers\Assistant;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Assistants\AssistantListResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;

class GetList extends BaseController
{
    public function __construct(private readonly int $limit)
    {
    }

    /**
     * @return AssistantListResponse
     */
    public function execute(): AssistantListResponse
    {
        try {
            return $this->getClient()->assistants()->list([
                'limit' => $this->limit,
            ]);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->errorExceptionHandler($exception);
        }
    }
}
