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
    private readonly ?Error $previous;

    public function __construct(mixed $message = '', mixed $code = self::CODE_DEFAULT, ?Error $previous = null)
    {
        $code = $this->prepareCode($code);

        $this->code = $code;
        $this->message = $message;
        $this->previous = $previous;
    }

    public static function make(mixed $message = '', mixed $code = self::CODE_DEFAULT, ?Error $previous = null): static
    {
        return new static($message, $code, $previous);
    }

    public static function makeWithReport(mixed $message = '', mixed $code = self::CODE_DEFAULT, ?Error $previous = null): static
    {
        $instance = new static($message, $code, $previous);
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

        $result = $this->code === $code;

        if ($result) {
            return true;
        }

        if (! empty($this->previous)) {
            return $this->previous->is($code);
        }

        return false;
    }

    public function jsonSerialize(): mixed
    {
        return $this->toJson();
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
        $json = [
            'error_message' => $this->message(),
            'error_code' => $this->code(),
        ];
        if (! empty($this->previous)) {
            $json['error_previous'] = $this->previous->toJson();
        }

        return json_encode($json);
    }

    public function wrap(mixed $message = '', mixed $code = self::CODE_DEFAULT): static
    {
        return new static($message, $code, $this);
    }
}
