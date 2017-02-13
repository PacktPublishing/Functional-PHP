<?php

require_once('05-applicative.php');

?>

<?php

abstract class Monad extends Applicative
{
    public static function return($value): Monad
    {
        return static::pure($value);
    }

    public abstract function bind(callable $f): Monad;
}

?>

<?php

function check_monad_laws($x, Monad $m, callable $f, callable $g)
{
    return [
        'left identity' => $m->return($x)->bind($f) == $f($x),
        'right identity' => $m->bind([$m, 'return']) == $m,
        'associativity' =>
            $m->bind($f)->bind($g) ==
            $m->bind(function($x) use($f, $g) { return $f($x)->bind($g); }),
    ];
}

?>

<?php

class IdentityMonad extends Monad
{
    private $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public static function pure($value): Applicative
    {
        return new static($value);
    }

    public function get()
    {
        return $this->value;
    }

    public function bind(callable $f): Monad
    {
        return $f($this->get());
    }

    public function apply(Applicative $a): Applicative
    {
        return static::pure($this->get()($a->get()));
    }
}

?>
