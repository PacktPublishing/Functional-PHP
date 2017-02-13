<?php

class Test
{
    private $value;

    public function __construct($v)
    {
        $this->set($v);
    }

    public function set($v) {
        $this->value = $v;
    }
}

function compare($a, $b)
{
    echo ($a == $b ? 'identical' : 'different')."\n";
}

$a = new Test(2);
$b = new Test(2);

compare($a, $b);
// identical

$b->set(10);
compare($a, $b);
// different

$c = clone $a;
$c->set(5);
compare($a, $c);

?>

<?php

?>
