<?php

namespace SMSkin\LaravelOpenAi\Support\SerializesModels;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Queue\SerializesModels;
use SMSkin\LaravelOpenAi\Support\SerializesModels\Contracts\ISerializableException;
use SMSkin\LaravelOpenAi\Support\SerializesModels\Models\ConnectExceptionModel;
use SMSkin\LaravelOpenAi\Support\SerializesModels\Models\RequestExceptionModel;
use SMSkin\LaravelOpenAi\Support\SerializesModels\Models\ThrowableModel;
use Throwable;

trait CustomSerializesModels
{
    use SerializesModels {
        getSerializedPropertyValue as parentGetSerializedPropertyValue;
        getRestoredPropertyValue as parentGetRestoredPropertyValue;
    }

    /** @noinspection PhpUnused */
    protected function getSerializedPropertyValue($value, $withRelations = true): mixed
    {
        if ($value instanceof ConnectException) {
            return new ConnectExceptionModel($value);
        }

        if ($value instanceof RequestException) {
            return new RequestExceptionModel($value);
        }

        if ($value instanceof Throwable) {
            return new ThrowableModel($value);
        }

        return $this->parentGetSerializedPropertyValue($value, $withRelations);
    }

    /** @noinspection PhpUnused */
    protected function getRestoredPropertyValue($value): mixed
    {
        if ($value instanceof ISerializableException) {
            return $value->unSerialize();
        }
        return $this->parentGetRestoredPropertyValue($value);
    }
}
