<?php

function sum(int $carry, int $i): int
{
    return $carry + $i;
}

$summed = array_reduce([1, 2, 3, 4], 'sum', 0);
/* $summed contains 10 */

?>

<?php

function in_array2(string $needle, array $haystack): bool
{
    $search = function(bool $contains, string $i) use ($needle) : bool {
          return $needle == $i ? true : $contains;
    };
    return array_reduce($haystack, $search, false);
}

var_dump(in_array2('two', ['one', 'two', 'three']));
// bool(true)

?>

<?php

function max2(array $data): int
{
    return array_reduce($data, function(int $max, int $i) : int {
        return $i > $max ? $i : $max;
    }, 0);
}

echo max2([5, 10, 23, 1, 0]);
// 23

?>

<?php

function max3(array $data): int
{
    return array_reduce($data, 'max', 0);
}

?>

<?php

function map(array $data, callable $cb): array
{
    return array_reduce($data, function(array $acc, $i) use ($cb) {
        $acc[] = $cb($i);
        return $acc;
    }, []);
}

function filter(array $data, callable $predicate): array
{
  return array_reduce($data, function(array $acc, $i) use ($predicate) {
      if($predicate($i)) {
          $acc[] = $i;
      }
      return $acc;
  }, []);
}

?>
