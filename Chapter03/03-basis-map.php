<?php

function square(int $x): int
{
    return $x * $x;
}

$squared = array_map('square', [1, 2, 3, 4]);
/* $squared contains [1, 4, 9, 16] */

?>

<?php

$numbers = [1, 2, 3, 4];
$english = ['one', 'two', 'three', 'four'];
$french = ['un', 'deux', 'trois', 'quatre'];

function translate(int $n, string $e, string $f): string
{
    return "$n is $e, or $f in French.";
}

print_r(array_map('translate', $numbers, $english, $french));

?>

Array
(
    [0] => 1 is one, or un in French.
    [1] => 2 is two, or deux in French.
    [2] => 3 is three, or trois in French.
    [3] => 4 is four, or quatre in French.
)

<?php

print_r(array_map(null, [1, 2], ['one', 'two'], ['un', 'deux']));

?>

Array
(
    [0] => Array
        (
            [0] => 1
            [1] => one
            [2] => un
        )
    [1] => Array
        (
            [0] => 2
            [1] => two
            [2] => deux
        )
)

<?php

  function add(int $a, int $b = 10): int
  {
      return $a + $b;
  }

  print_r(array_map('add', ['one' => 1, 'two' => 2]));
  print_r(array_map('add', [1, 2], [20, 30]));
?>

Array
(
    [one] => 11
    [two] => 12
)
Array
(
    [0] => 21
    [1] => 32
)
