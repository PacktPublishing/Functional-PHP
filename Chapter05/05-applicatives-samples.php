<?php

require_once('04-curry.php');
require_once('05-functor.php');

?>

<?php

$add = curry(function(int $a, int $b) { return $a + $b; });

$id = new IdentityFunctor(5);

?>

<?php

$hum = $id->map($add);

echo get_class($hum->get());
// Closure

?>

<?php

$result = $hum->map(function(callable $f) {
    return $f(10);
});
echo $result->get();
// 15

?>

<?php

class IdentityFunctorExtended extends IdentityFunctor
{
    public function apply(IdentityFunctorExtended $f)
    {
        return $f->map($this->get());
    }
}

$applicative = (new IdentityFunctorExtended(5))->map($add);
$ten = new IdentityFunctorExtended(10);
echo $applicative->apply($ten)->get();
// 15

?>

<?php

$five = new IdentityFunctorExtended(5);
$ten = new IdentityFunctorExtended(10);
$applicative = new IdentityFunctorExtended($add);

echo $applicative->apply($five)->apply($ten)->get();
// 15

?>

<?php

require_once('05-applicative.php');

?>

<?php

$five = IdentityApplicative::pure(5);
$ten = IdentityApplicative::pure(10);
$applicative = IdentityApplicative::pure($add);

echo $applicative->apply($five)->apply($ten)->get();
// 15

$hello = IdentityApplicative::pure('Hello world!');

echo IdentityApplicative::pure('strtoupper')->apply($hello)->get();
// HELLO WORLD!

echo $hello->map('strtoupper')->get();
// HELLO WORLD!

?>

<?php

print_r(check_applicative_laws(
    IdentityApplicative::pure('strtoupper'),
    'trim',
    ' Hello World! '
));
// Array
// (
//     [identity] => 1
//     [homomorphism] => 1
//     [interchange] => 1
//     [composition] => 1
//     [map] => 1
// )

?>

<?php

print_r(iterator_to_array(CollectionApplicative::pure([
  function($a) { return $a * 2; },
  function($a) { return $a + 10; }
])->apply(CollectionApplicative::pure([1, 2, 3]))));
// Array
// (
//     [0] => 2
//     [1] => 4
//     [2] => 6
//     [3] => 11
//     [4] => 12
//     [5] => 13
// )


?>

<?php

use function Functional\group;

function limit_size($image) { return $image; }
function thumbnail($image) { return $image.'_tn'; }
function mobile($image) { return $image.'_small'; }

$images = CollectionApplicative::pure(['one', 'two', 'three']);

$process = CollectionApplicative::pure([
  'limit_size', 'thumbnail', 'mobile'
]);

$transformed = group($process->apply($images), function($image, $index) {
    return $index % 3;
});

?>

<?php

print_r($transformed);
// Array
// (
//     [0] => Array
//         (
//             [0] => one
//             [3] => one_tn
//             [6] => one_small
//         )
//
//     [1] => Array
//         (
//             [1] => two
//             [4] => two_tn
//             [7] => two_small
//         )
//
//     [2] => Array
//         (
//             [2] => three
//             [5] => three_tn
//             [8] => three_small
//         )
//
// )

?>
