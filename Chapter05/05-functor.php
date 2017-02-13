<?php

interface Functor
{
    public function map(callable $f): Functor;
}

?>

<?php

class IdentityFunctor implements Functor
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function map(callable $f): Functor
    {
        return new static($f($this->value));
    }

    public function get()
    {
        return $this->value;
    }
}

?>

<?php

function check_functor_laws(Functor $func, callable $f, callable $g)
{
    $id = function($a) { return $a; };
    $composed = function($a) use($f, $g) { return $g($f($a)); };

    return [
        'identity' => $func->map($id) == $id($func),
        'composition' => $func->map($f)->map($g) == $func->map($composed)
    ];
}

?>
