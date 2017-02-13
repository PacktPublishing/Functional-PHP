<?php

function id($value)
{
    return $value;
}

?>

<?php

$data = [1, 2, 3, 4];

var_dump(array_map('id', $data) === id($data));
// bool(true)

?>

<?php

function add2($a)
{
    return $a + 2;
}

function times10($a)
{
    return $a * 10;
}

function composed($a) {
    return add2(times10($a));
}

var_dump(
    array_map('add2', array_map('times10', $data)) ===
    array_map('composed', $data)
);
// bool(true)

?>

<?php

require_once('03-maybe-final.php');

?>

<?php

$just = Maybe::just(10);
$nothing = Maybe::nothing();

var_dump($just->map('id') == id($just));
// bool(true)

var_dump($nothing->map('id') === id($nothing));
// bool(true)

?>

<?php

var_dump($just->map('times10')->map('add2') == $just->map('composed'));
// bool(true)

var_dump($nothing->map('times10')->map('add2') === $nothing->map('composed'));
// bool(true)

?>

<?php

require_once('05-functor.php');

?>

<?php

print_r(check_functor_laws(
    new IdentityFunctor(10),
    function($a) { return $a * 10; },
    function($a) { return $a + 2; }
));
// Array
// (
//     [identity] => 1
//     [composition] => 1
// )

?>
