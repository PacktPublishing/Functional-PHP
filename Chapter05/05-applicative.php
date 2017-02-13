<?php

require_once('05-functor.php');

?>

<?php

abstract class Applicative implements Functor
{
    public abstract static function pure($value): Applicative;

    public abstract function apply(Applicative $f): Applicative;

    public function map(callable $f): Functor
    {
        return $this->pure($f)->apply($this);
    }
}

?>

<?php

class IdentityApplicative extends Applicative
{
    private $value;

    protected function __construct($value)
    {
        $this->value = $value;
    }

    public static function pure($value): Applicative
    {
        return new static($value);
    }

    public function apply(Applicative $f): Applicative
    {
        return static::pure($this->get()($f->get()));
    }

    public function get()
    {
        return $this->value;
    }
}

?>

<?php

function check_applicative_laws(Applicative $f1, callable $f2, $x)
{
    $identity = function($x) { return $x; };
    $compose = function(callable $a) {
        return function(callable $b) use($a) {
            return function($x) use($a, $b) {
                return $a($b($x));
            };
        };
    };

    $pure_x = $f1->pure($x);
    $pure_f2 = $f1->pure($f2);

    return [
        'identity' =>
            $f1->pure($identity)->apply($pure_x) ==
            $pure_x,
        'homomorphism' =>
            $f1->pure($f2)->apply($pure_x) ==
            $f1->pure($f2($x)),
        'interchange' =>
            $f1->apply($pure_x) ==
            $f1->pure(function($f) use($x) { return $f($x); })->apply($f1),
        'composition' =>
            $f1->pure($compose)->apply($f1)->apply($pure_f2)->apply($pure_x) ==
            $f1->apply($pure_f2->apply($pure_x)),
        'map' =>
            $pure_f2->apply($pure_x) ==
            $pure_x->map($f2)
    ];
}

?>

<?php

class CollectionApplicative extends Applicative implements IteratorAggregate
{
    private $values;

    protected function __construct($values)
    {
        $this->values = $values;
    }

    public static function pure($values): Applicative
    {
        if($values instanceof Traversable) {
            $values = iterator_to_array($values);
        } else if(! is_array($values)) {
            $values = [$values];
        }

        return new static($values);
    }

    public function apply(Applicative $data): Applicative
    {
        return $this->pure(array_reduce($this->values,
            function($acc, callable $function) use($data) {
                return array_merge($acc, array_map($function, $data->values) );
            }, [])
        );
    }

    public function getIterator() {
        return new ArrayIterator($this->values);
    }
}

?>
