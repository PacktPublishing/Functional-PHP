<?php

use Functional as f;

function add($a, $b)
{
    return $a + $b;
}

function manualCurryAdd($a, $b = null) {
    $func = function($b) use($a) {
        return $a + $b;
    };

    return func_num_args() > 1 ? $func($b) : $func;
}

$curryiedAdd = f\curry('add');

function add2($b)
{
    return $b + 2;
}

function add4($b)
{
    return $b + 4;
}

$composedAdd4 = f\compose('add2', 'add2');

$composerCurryedAdd = f\compose($curryiedAdd(2), $curryiedAdd(2));

?>

<?php

class Integer {
    private $value;
    public function __construct($v) { $this->value = $v; }
    public function get() { return $this->value; }
}


class Adder {
    public function add(Integer $a, Integer $b) {
        return $a->get() + $b->get();
    }
}

?>
