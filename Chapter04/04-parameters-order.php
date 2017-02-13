<?php

require_once('04-curry.php');

?>

<?php

$map = curry_n(2, 'array_map');
$filter = curry_n(2, 'array_filter');

?>

<?php

$trim = $map('trim');
$hash = $map('sha1');

$oddNumbers = $filter([1, 3, 5, 7]);
$vowels = $filter(['a', 'e', 'i', 'o', 'u']);

?>

<?php

$map = curry(function(array $array, callable $cb) {});
$take = curry(function(string $string, int $count) {});

$firstTwo = function(array $array) {
    return $map($array, function(string $s) {
        return $take($s, 2);
    });
}

?>

<?php

$map = curry(function(callable $cb, array $array) {});
$take = curry(function(int $count, string $string) {});

$firstTwo = $map($take(2));
?>

<?php

use function Functional\partial_right;

$firstTwo = partial_right($map, partial_right($take, 2));

?>
