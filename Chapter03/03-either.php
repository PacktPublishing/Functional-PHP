<?php

abstract class Either
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public static function right($value): Right
    {
        return new Right($value);
    }

    public static function left($value): Left
    {
        return new Left($value);
    }

    abstract public function isRight(): bool;

    abstract public function isLeft(): bool;

    abstract public function getRight();

    abstract public function getLeft();

    abstract public function getOrElse($default);

    abstract public function orElse(Either $e): Either;

    abstract public function map(callable $f): Either;

    abstract public function flatMap(callable $f): Either;

    abstract public function filter(callable $f, $error): Either;
}

?>

<?php

final class Right extends Either
{
    public function isRight(): bool
    {
        return true;
    }

    public function isLeft(): bool
    {
        return false;
    }

    public function getRight()
    {
        return $this->value;
    }

    public function getLeft()
    {
        return false;
    }

    public function getOrElse($default)
    {
        return $this->value;
    }

    public function orElse(Either $e): Either
    {
        return $this;
    }

    public function map(callable $f): Either
    {
        return new Right($f($this->value));
    }
    public function flatMap(callable $f): Either
    {
        return $f($this->value);
    }

    public function filter(callable $f, $error): Either
    {
        return $f($this->value) ? $this : new Left($error);
    }
}

final class Left extends Either
{
    public function isRight(): bool
    {
        return false;
    }

    public function isLeft(): bool
    {
        return true;
    }

    public function getRight()
    {
        return false;
    }

    public function getLeft()
    {
        return $this->value;
    }

    public function getOrElse($default)
    {
        return $default;
    }

    public function orElse(Either $e): Either
    {
        return $e;
    }

    public function map(callable $f): Either
    {
        return $this;
    }

    public function flatMap(callable $f): Either
    {
        return $this;
    }

    public function filter(callable $f, $error): Either
    {
        return $this;
    }
}

?>

<?php

function liftEither(callable $f, $error = "An error occured")
{
    return function() use ($f)
    {
        if(array_reduce(func_get_args(), function(bool $status, Either $e) {
            return $e->isLeft() ? false : $status;
        }, true)) {
            $args = array_map(function(Either $e) {
                // it is safe to do so because the fold above checked
                // that all arguments are of type Some
                return $e->getRight(null);
            }, func_get_args());
            return Either::right(call_user_func_array($f, $args));
        }

        return Either::left($error);
    };
}

?>
