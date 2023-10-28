<?php

namespace OpResult;

use Exception;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;
use Stringable;
use UnitEnum;

class Error implements Stringable, Jsonable, JsonSerializable
{
    public const CODE_DEFAULT = 'UNKNOWN';
    private readonly mixed $message;
    private readonly mixed $code;

    public function __construct(mixed $message = '', mixed $code = self::CODE_DEFAULT)
    {
        $code = $this->prepareCode($code);

        $this->code = $code;
        $this->message = $message;
    }

    public static function make(mixed $message = '', mixed $code = self::CODE_DEFAULT): static
    {
        return new static($message, $code);
    }

    public static function makeWithReport(mixed $message = '', mixed $code = self::CODE_DEFAULT): static
    {
        $instance = new static($message, $code);
        self::report($instance);

        return $instance;
    }

    public static function report(Error $error): self
    {
        report(new Exception($error));

        return $error;
    }

    public function __toString(): string
    {
        return $this->toJson();
    }

    public function code(): mixed
    {
        return $this->code;
    }

    public function is(mixed $code = null): bool
    {
        if (is_null($code)) {
            return false;
        }

        $code = $this->prepareCode($code);

        return $this->code === $code;
    }

    public function message(): mixed
    {
        return $this->message;
    }

    /**
     * @param mixed $code
     * @return mixed|string
     */
    public function prepareCode(mixed $code): mixed
    {
        if ($code instanceof UnitEnum) {
            $code = $code->name;
        }
        return $code;
    }

    public function reportt()
    {
        return self::report($this);
    }

    public function toJson($options = 0)
    {
        return json_encode([
            'error_message' => $this->message(),
            'error_code' => $this->code(),
        ]);
    }

    public function jsonSerialize(): mixed
    {
        return $this->toJson();
    }
}
