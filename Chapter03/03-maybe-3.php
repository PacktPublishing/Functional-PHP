<?php

abstract class Maybe
{
    // [...]

    abstract public function orElse(Maybe $m): Maybe;

    abstract public function flatMap(callable $f): Maybe;

    abstract public function filter(callable $f): Maybe;
}

final class Just extends Maybe
{
    // [...]

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
    // [...]

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

?>
