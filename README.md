This library is based on the official PHP OpenAI library [openai-php/client](https://github.com/openai-php/client).

### Installation
```text
composer require smskin/laravel-opeai
php artisan vendor:publish --provider="SMSkin\LaravelOpenAi\Providers\ServiceProvider"
```

A config file will be created ```config/openai.php```

Environments:
- OPENAI_API_KEY - API key
- OPENAI_ASYNC_TASK_CONNECTION - connection for queued tasks (default: null)
- OPENAI_ASYNC_TASK_QUEUE - queue for queued tasks (default: null)

### Components:

#### \SMSkin\LaravelOpenAi\Api
Main class with which you can access modules

#### \SMSkin\LaravelOpenAi\AssistantModule
[Base library docs](https://github.com/openai-php/client?tab=readme-ov-file#assistants-resource)

#### \SMSkin\LaravelOpenAi\AudioModule
[Base library docs](https://github.com/openai-php/client?tab=readme-ov-file#audio-resource)

#### \SMSkin\LaravelOpenAi\ChatModule
[Base library docs](https://github.com/openai-php/client?tab=readme-ov-file#chat-resource)

#### \SMSkin\LaravelOpenAi\CompletionModule
[Base library docs](https://github.com/openai-php/client?tab=readme-ov-file#completions-resource)

### \SMSkin\LaravelOpenAi\ImageModule
[Base library docs](https://github.com/openai-php/client?tab=readme-ov-file#images-resource)

### \SMSkin\LaravelOpenAi\ThreadModule
[Base library docs](https://github.com/openai-php/client?tab=readme-ov-file#threads-resource)

### \SMSkin\LaravelOpenAi\ThreadMessageModule
[Base library docs](https://github.com/openai-php/client?tab=readme-ov-file#threads-messages-resource)

### \SMSkin\LaravelOpenAi\ThreadRunModule
[Base library docs](https://github.com/openai-php/client?tab=readme-ov-file#threads-runs-resource)
