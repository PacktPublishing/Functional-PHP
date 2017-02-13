<?php

abstract class Monoid
{
    public abstract static function id();
    public abstract static function op($a, $b);

    public static function concat(array $values)
    {
        $class = get_called_class();
        return array_reduce($values, [$class, 'op'], [$class, 'id']());
    }

    public function __invoke(...$args)
    {
        switch(count($args)) {
            case 0: throw new RuntimeException("Except at least 1 parameter");
            case 1:
                return function($b) use($args) {
                    return static::op($args[0], $b);
                };
            default:
                return static::concat($args);
        }
    }
}

?>

<?php

function check_monoid_laws(Monoid $m, $a, $b, $c)
{
    return [
        'left identity' => $m->op($m->id(), $a) == $a,
        'right identity' => $m->op($a, $m->id()) == $a,
        'associativity' =>
            $m->op($m->op($a, $b), $c) ==
            $m->op($a, $m->op($b, $c))
    ];
}

?>
