<?php

namespace SMSkin\LaravelOpenAi\Controllers\Image;

use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Images\CreateResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\ImageResponseFormatEnum;
use SMSkin\LaravelOpenAi\Enums\ImageSizeEnum;
use SMSkin\LaravelOpenAi\Enums\ImageStyleEnum;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\NotValidModel;

class Create extends BaseController
{
    public function __construct(
        private readonly string $prompt,
        private readonly ModelEnum $model,
        private readonly int $n,
        private readonly ImageSizeEnum $size,
        private readonly ImageStyleEnum $style,
        private readonly ImageResponseFormatEnum $responseFormat
    ) {
    }

    /**
     * @throws NotValidModel
     */
    public function execute(): CreateResponse
    {
        try {
            return $this->getClient()->images()->create([
                'model' => $this->model->value,
                'prompt' => $this->prompt,
                'n' => $this->n,
                'size' => $this->size->value,
                'style' => $this->style,
                'response_format' => $this->responseFormat->value,
            ]);
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'You are not allowed to sample from this model')) {
                throw new NotValidModel($exception->getMessage(), 500, $exception);
            }
            $this->errorExceptionHandler($exception);
        }
    }
}
