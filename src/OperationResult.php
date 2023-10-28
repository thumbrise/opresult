<?php

namespace OpResult;

use Illuminate\Contracts\Support\Jsonable;
use Stringable;

/**
 * @template T
 */
class OperationResult implements Stringable, Jsonable
{
    /**
     * @param mixed|null|T $data
     * @param Error|null $error
     */
    public function __construct(
        public mixed  $data = null,
        public ?Error $error = null,
    )
    {
    }

    public static function error(mixed $message = '', $code = Error::CODE_DEFAULT): static
    {
        return new static(null, Error::make($message, $code));
    }

    public static function errorWithReport(mixed $message = '', $code = Error::CODE_DEFAULT): static
    {
        return new static(null, Error::makeWithReport($message, $code));
    }

    public static function success(mixed $data = null): static
    {
        return new static($data, null);
    }

    public function __toString(): string
    {
        return $this->toJson();
    }

    public function isError(mixed $code = null): bool
    {
        $errorExists = ! empty($this->error);

        if (! is_null($code) && $errorExists) {
            return $this->error->is($code);
        }

        return $errorExists;
    }

    public function isSuccess(): bool
    {
        return ! $this->isError();
    }

    public function toJson($options = 0)
    {
        if ($this->isError()) {
            return $this->error->toJson($options);
        }

        return json_encode([
            'data' => $this->data
        ]);
    }

    public function withData(mixed $data): static
    {
        $this->data = $data;
        return $this;
    }

    public function withError(mixed $message = '', $code = Error::CODE_DEFAULT): static
    {
        $this->error = Error::make($message, $code);
        return $this;
    }

    public function withoutData(): static
    {
        $this->data = null;
        return $this;
    }

    public function withoutError(): static
    {
        $this->error = null;
        return $this;
    }
}
