<?php
require_once __DIR__.'/03-maybe-final.php';
?>

<?php

function lift(callable $f)
{
    return function() use ($f)
    {
        if(array_reduce(func_get_args(), function(bool $status, Maybe $m) {
            return $m->isNothing() ? false : $status;
        }, true)) {
            $args = array_map(function(Maybe $m) {
                // it is safe to do so because the fold above checked
                // that all arguments are of type Some
                return $m->getOrElse(null);
            }, func_get_args());
            return Maybe::just(call_user_func_array($f, $args));
        }

        return Maybe::nothing();
    };
}

?>

<?php

function add(int $a, int $b)
{
    return $a + $b;
}

$add2 = lift('add');

echo $add2(Maybe::just(1), Maybe::just(5))->getOrElse('nothing');
// 6

echo $add2(Maybe::just(1), Maybe::nothing())->getOrElse('nothing');
// nothing

?>
