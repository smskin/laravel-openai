<?php

namespace SMSkin\LaravelOpenAi\Controllers\Assistant;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Responses\Assistants\AssistantResponse;
use SMSkin\LaravelOpenAi\Controllers\BaseController;
use SMSkin\LaravelOpenAi\Enums\ModelEnum;
use SMSkin\LaravelOpenAi\Exceptions\NotValidModel;
use SMSkin\LaravelOpenAi\Exceptions\RetrievalToolNotSupported;
use SMSkin\LaravelOpenAi\Models\BaseTool;

class Create extends BaseController
{
    /**
     * @param ModelEnum $model
     * @param string|null $name
     * @param string|null $description
     * @param string|null $instructions
     * @param Collection<BaseTool>|null $tools
     */
    public function __construct(
        private readonly ModelEnum $model,
        private readonly string|null $name,
        private readonly string|null $description,
        private readonly string|null $instructions,
        private readonly Collection|null $tools
    )
    {
    }

    /**
     * @throws NotValidModel
     * @throws RetrievalToolNotSupported
     */
    public function execute(): AssistantResponse
    {
        try {
            return $this->getClient()->assistants()->create(
                $this->prepareData()
            );
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ErrorException $exception) {
            if (Str::contains($exception->getMessage(), 'cannot be used with the \'retrieval\' tool')) {
                throw new RetrievalToolNotSupported($exception->getMessage(), 500, $exception);
            }
            if (Str::contains($exception->getMessage(), 'cannot be used with the Assistants API')) {
                throw new NotValidModel($exception->getMessage(), 500, $exception);
            }
            $this->errorExceptionHandler($exception);
        }
    }

    private function prepareData(): array
    {
        $data = [
            'model' => $this->model->value,
        ];
        if (filled($this->name)) {
            $data['name'] = $this->name;
        }
        if (filled($this->description)) {
            $data['description'] = $this->description;
        }
        if (filled($this->instructions)) {
            $data['instructions'] = $this->instructions;
        }
        if (filled($this->tools)) {
            $data['tools'] = $this->tools->map(static function (BaseTool $tool) {
                return $tool->toArray();
            })->toArray();
        }
        return $data;
    }
}
