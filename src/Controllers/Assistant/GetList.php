<?php

namespace SMSkin\LaravelOpenAi\Controllers\Assistant;

use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Responses\Assistants\AssistantListResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\OrderEnum;
use SMSkin\LaravelOpenAi\Exceptions\ApiServerHadProcessingError;

class GetList extends BaseController
{
    /**
     * @throws TransporterException
     * @throws ApiServerHadProcessingError
     * @throws ErrorException
     * @noinspection PhpDocRedundantThrowsInspection
     */
    public function execute(int|null $limit, OrderEnum|null $order, string|null $after, string|null $before): AssistantListResponse
    {
        try {
            return $this->getClient()->assistants()->list(
                $this->prepareParams($limit, $order, $after, $before)
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            $this->globalExceptionHandler($exception);
        }
    }

    private function prepareParams(int|null $limit, OrderEnum|null $order, string|null $after, string|null $before): array
    {
        $payload = [];
        if ($limit !== null) {
            $payload['limit'] = $limit;
        }
        if ($order) {
            $payload['order'] = $order->value;
        }
        if ($after !== null) {
            $payload['after'] = $after;
        }
        if ($before !== null) {
            $payload['before'] = $before;
        }
        return $payload;
    }
}
