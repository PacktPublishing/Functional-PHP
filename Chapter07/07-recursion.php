<?php

function simple() {
    return strtoupper('Hello!');
}

?>

<?php

function multiple_branches($name) {
    if($name == 'Gilles') {
        return strtoupper('Hi friend!');
    }

    return strtoupper('Greetings');
}

?>

<?php

function not_a_tail_call($name) {
    return strtoupper('Hello') + ' ' + $name;
}

function also_not_a_tail_call($a) {
    return 2 * max($a, 10);
}

?>

<?php

function fact($n)
{
    return $n <= 1 ? 1 : $n * fact($n - 1);
}

?>

<?php

function fact2($n)
{
    $fact = function($n, $acc) use (&$fact) {
        return $n <= 1 ? $acc : $fact($n - 1, $n * $acc);
    };

    return $fact($n, 1);
}

?>

<?php

function fact3($n, $acc = 1)
{
    return $n <= 1 ? $acc : fact3($n - 1, $n * $acc);
}

?>

<?php

use Functional as f;

class Position
{
    public $disc;
    public $src;
    public $dst;
    public $via;

    public function __construct($n, $s, $d, $v)
    {
        $this->disc = $n;
        $this->src = $s;
        $this->dst = $d;
        $this->via = $v;
    }
}

function hanoi(Position $pos, array $moves = [])
{
    if ($pos->disc === 1) {
        echo("Move a disc from the {$pos->src} rod to the {$pos->dst} rod\n");

        if(count($moves) > 0) {
            hanoi(f\head($moves), f\tail($moves));
        }
    } else {
        $pos1 = new Position($pos->disc - 1, $pos->src, $pos->via, $pos->dst);
        $pos2 = new Position(1, $pos->src, $pos->dst, $pos->via);
        $pos3 = new Position($pos->disc - 1, $pos->via, $pos->dst, $pos->src);

        hanoi($pos1, array_merge([$pos2, $pos3], $moves));
    }
}

hanoi(new Position(3, 'left', 'right', 'middle'));

?>

<?php

class Bounce
{
    private $f;
    private $args;

    public function __construct(callable $f, ...$args)
    {
        $this->f = $f;
        $this->args = $args;
    }

    public function __invoke()
    {
        return call_user_func_array($this->f, $this->args);
    }
}

function trampoline(callable $f, ...$args) {
    $return = call_user_func_array($f, $args);

    while($return instanceof Bounce) {
        $return = $return();
    }
    return $return;
}

?>

<?php

function fact4($n, $acc = 1)
{
    return $n <= 1 ? $acc : new Bounce('fact4', $n - 1, $n * $acc);
}

echo trampoline('fact4', 5)
// 120

?>

<?php

function even($n) {
    return $n == 0 ? 'yes' : odd($n - 1);
}

function odd($n) {
    return $n == 0 ? 'no' : even($n - 1);
}

echo even(10);
// yes

echo odd(10);
// no

?>

<?php

use FunctionalPHP\Trampoline as t;

function factorial($n, $acc = 1) {
    return $n <= 1 ? $acc : t\bounce('factorial', $n - 1, $n * $acc);
};

echo t\trampoline('factorial', 5);
// 120

use FunctionalPHP\Trampoline\Trampoline;

echo Trampoline::factorial(5);
// 120

echo Trampoline::strtoupper('Hello!');
// HELLO!

?>

<?php

$fact = t\trampoline_wrapper('factorial');

echo $fact(5);
// 120

?>

<?php

$fact = T\pool(function($n, $acc = 1) {
    return $n <= 1 ? $acc : $this($n - 1, $n * $acc);
});

echo $fact(5);
// 120

?>
