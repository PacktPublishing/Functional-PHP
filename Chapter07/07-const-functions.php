<?php

use function Functional\compose;

?>

<?php

const push = 'Widmogrod\Functional\push';

function push(array $array, array $values)
{
    // [...]
}

?>

<?php

const increment = 'increment';

function increment(int $i) { return $i + 1; }

// using a 'callable'
array_map([1, 2, 3, 4], 'increment');

// using our const
array_map([1, 2, 3, 4], increment);

?>

<?php

class A {
    public static function static_test() {}
    public function test() {}
}

/** @var callable */
const A_static = ['A', 'static_test'];

?>
