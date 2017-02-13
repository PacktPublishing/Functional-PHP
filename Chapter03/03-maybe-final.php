<?php

abstract class Maybe
{
    public static function just($value): Just
    {
        return new Just($value);
    }

    public static function nothing(): Nothing
    {
        return Nothing::get();
    }

    public static function fromValue($value, $nullValue = null)
    {
        return $value === $nullValue ?
            self::nothing() :
            self::just($value);
    }

    abstract public function isJust(): bool;

    abstract public function isNothing(): bool;

    abstract public function getOrElse($default);

    abstract public function map(callable $f): Maybe;

    abstract public function orElse(Maybe $m): Maybe;

    abstract public function flatMap(callable $f): Maybe;

    abstract public function filter(callable $f): Maybe;
}

final class Just extends Maybe
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function isJust(): bool
    {
        return true;
    }

    public function isNothing(): bool
    {
        return false;
    }

    public function getOrElse($default)
    {
        return $this->value;
    }

    public function map(callable $f): Maybe
    {
        return new self($f($this->value));
    }

    public function orElse(Maybe $m): Maybe
    {
        return $this;
    }

    public function flatMap(callable $f): Maybe
    {
        return $f($this->value);
    }

    public function filter(callable $f): Maybe
    {
        return $f($this->value) ? $this : Maybe::nothing();
    }
}

final class Nothing extends Maybe
{
    private static $instance = null;
    public static function get()
    {
        if(is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function isJust(): bool
    {
        return false;
    }

    public function isNothing(): bool
    {
        return true;
    }

    public function getOrElse($default)
    {
        return $default;
    }

    public function map(callable $f): Maybe
    {
        return $this;
    }

    public function orElse(Maybe $m): Maybe
    {
        return $m;
    }

    public function flatMap(callable $f): Maybe
    {
        return $this;
    }

    public function filter(callable $f): Maybe
    {
        return $this;
    }
}
