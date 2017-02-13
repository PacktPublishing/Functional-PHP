<?php

abstract class Maybe
{
    // [...]

    public static function fromValue($value, $nullValue = null)
    {
        return $value === $nullValue ?
            self::nothing() :
            self::just($value);
    }

    abstract public function map(callable $f): Maybe;
}

final class Just extends Maybe
{
    // [...]

    public function map(callable $f): Maybe
    {
        return new self($f($this->value));
    }
}

final class Nothing extends Maybe
{
    // [...]

    public function map(callable $f): Maybe
    {
        return $this;
    }
}

?>
