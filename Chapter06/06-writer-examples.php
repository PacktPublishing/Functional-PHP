<?php

require_once('06-monadic_helpers.php');
require_once('06-writer-monad.php');
use Monad\Writer;
use Monad\StringMonoid;

?>

<?php

$data = [1, 10, 15, 20, 25];

$filter = function($i) {
    if ($i % 2 == 1) {
        return new Writer(false, "Reject odd number $i.\n");
    } else if($i > 15) {
      return new Writer(false, "Reject $i because it is bigger than 15\n");
    }

    return new Writer(true);
};

list($result, $log) = filterM($filter, $data)->runWriter();

var_dump($result);
// array(1) {
//   [0]=> int(10)
// }

echo $log->get();
// Reject odd number 1.
// Reject odd number 15.
// Reject 20 because it is bigger than 15
// Reject odd number 25.

?>

<?php

function some_complex_function(int $input)
{
    $msg = new StringMonoid('received: '.print_r($input, true).'. ');

    if($input > 10) {
        $w = new Writer($input / 2, $msg->concat(new StringMonoid("Halved the value. ")));
    } else {
        $w = new Writer($input, $msg);
    }

    if($input > 20)
    {
        return $w->bind('some_complex_function');
    }

    return $w;
}

list($value, $log) = (new Writer(15))->bind('some_complex_function')->runWriter();
echo $log->get();
// received: 15. Halved the value.

list($value, $log) = some_complex_function(27)->runWriter();
echo $log->get();
// received: 27. Halved the value. received: 13. Halved the value.

list($value, $log) = some_complex_function(50)->runWriter();
echo $log->get();
// received: 50. Halved the value. received: 25. Halved the value. received: 12. Halved the value.

?>
