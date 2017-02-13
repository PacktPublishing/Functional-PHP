<?php

use QCheck\Generator;
use QCheck\Quick;

$singleElement = Quick::check(1000, Generator::forAll(
    [Generator::ints()],
    function($i) {
        return array_reverse([$i]) == [$i];
    }
), ['echo' => true]);

$inverse = Quick::check(1000, Generator::forAll(
    [Generator::ints()->intoArrays()],
    function($array) {
        return array_reverse(array_reverse($array)) == $array;
    }
), ['echo' => true]);

$merge = Quick::check(1000, Generator::forAll(
    [Generator::ints()->intoArrays(), Generator::ints()->intoArrays()],
    function($x, $y) {
        return
            array_reverse(array_merge($x, $y)) ==
            array_merge(array_reverse($y), array_reverse($x));
    }
), ['echo' => true]);

?>

<?php

/**
 * @param string $s
 * @return bool
 */
function my_function($s) {
    return is_string($s);
}

Annotation::check('my_function');

?>
