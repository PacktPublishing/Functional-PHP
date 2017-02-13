<?php

require_once('05-monoid.php');

?>

<?php

$a = 10; $b = 20; $c = 30;

var_dump($a + 0 === $a);
// bool(true)
var_dump(0 + $a === $a);
// bool(true)
var_dump(($a + $b) + $c === $a + ($b + $c));
// bool(true)

?>

<?php

var_dump($a * 1 === $a);
// bool(true)
var_dump(1 * $a === $a);
// bool(true)
var_dump(($a * $b) * $c === $a * ($b * $c));
// bool(true)

?>

<?php

$v1 = [1, 2, 3]; $v2 = [5]; $v3 = [10];

var_dump(array_merge($v1, []) === $v1);
// bool(true)
var_dump(array_merge([], $v1) === $v1);
// bool(true)
var_dump(
  array_merge(array_merge($v1, $v2), $v3) ===
  array_merge($v1, array_merge($v2, $v3))
);
// bool(true)

?>

<?php

$s1 = "Hello"; $s2 = " World"; $s3 = "!";

var_dump($s1 . '' === $s1);
// bool(true)
var_dump('' . $s1 === $s1);
// bool(true)
var_dump(($s1 . $s2) . $s3 == $s1 . ($s2 . $s3));
// bool(true)

?>

<?php

var_dump(($a - $b) - $c === $a - ($b - $c));
// bool(false)
var_dump(($a / $b) / $c === $a / ($b / $c));
// bool(false)

?>

<?php

class IntSum extends Monoid
{
    public static function id() { return 0; }
    public static function op($a, $b) { return $a + $b; }
}

class IntProduct extends Monoid
{
    public static function id() { return 1; }
    public static function op($a, $b) { return $a * $b; }
}

class StringConcat extends Monoid
{
    public static function id() { return ''; }
    public static function op($a, $b) { return $a.$b; }
}

class ArrayMerge extends Monoid
{
    public static function id() { return []; }
    public static function op($a, $b) { return array_merge($a, $b); }
}

?>

<?php

print_r(check_monoid_laws(new IntSum(), 5, 10, 20));
// Array
// (
//     [left identity] => 1
//     [right identity] => 1
//     [associativity] => 1
// )

print_r(check_monoid_laws(new IntProduct(), 5, 10, 20));
// Array
// (
//     [left identity] => 1
//     [right identity] => 1
//     [associativity] => 1
// )

print_r(check_monoid_laws(new StringConcat(), "Hello ", "World", "!"));
// Array
// (
//     [left identity] => 1
//     [right identity] => 1
//     [associativity] => 1
// )

print_r(check_monoid_laws(new ArrayMerge(), [1, 2, 3], [4, 5], [10]));
// Array
// (
//     [left identity] => 1
//     [right identity] => 1
//     [associativity] => 1
// )

?>

<?php

class IntSubtraction extends Monoid
{
    public static function id() { return 0; }
    public static function op($a, $b) { return $a - $b; }
}

print_r(check_monoid_laws(new IntSubtraction(), 5, 10, 20));
// Array
// (
//     [left identity] =>
//     [right identity] => 1
//     [associativity] =>
// )

?>

<?php

class Any extends Monoid
{
    public static function id() { return false; }
    public static function op($a, $b) { return $a || $b; }
}

class All extends Monoid
{
    public static function id() { return true; }
    public static function op($a, $b) { return $a && $b; }
}

print_r(check_monoid_laws(new Any(), true, false, true));
// Array
// (
//     [left identity] => 1
//     [right identity] => 1
//     [associativity] => 1
// )

print_r(check_monoid_laws(new All(), true, false, true));
// Array
// (
//     [left identity] => 1
//     [right identity] => 1
//     [associativity] => 1
// )

?>

<?php

echo Any::concat([true, false, true, false]) ? 'true' : 'false';
// true

echo All::concat([true, false, true, false]) ? 'true' : 'false';
// false

?>

<?php

$numbers = [1, 23, 45, 187, 12];
echo IntSum::concat($numbers);
// 268

$words = ['Hello ', ', ', 'my ', 'name is John.'];
echo StringConcat::concat($words);
// Hello , my name is John.

$arrays = [[1, 2, 3], ['one', 'two', 'three'], [true, false]];
print_r(ArrayMerge::concat($arrays));
// [1, 2, 3, 'one', 'two', 'three', true, false]

?>

<?php

use function Functional\compose;

$add = new IntSum();
$times = new IntProduct();

$composed = compose($add(5), $times(2));
echo $composed(2);
// 14

?>
