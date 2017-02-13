<?php

use Widmogrod\Monad\Maybe as m;
use Widmogrod\Functional as f;

$just = m\just(10);
$nothing = m\nothing();

$just = m\maybeNull(10);
$nothing = m\maybeNull(null);

echo maybe('Hello.', 'strtoupper', m\maybe('Hi!'));
// HI!

echo maybe('Hello.', 'strtoupper', m\nothing());
// HELLO.

?>

<?php

$divide = function($acc, $i) {
    return $i == 0 ? nothing() : just($acc / $i);
};

var_dump(f\foldM($divide, 100, [2, 5, 2])->extract());
// int(5)

var_dump(f\foldM($divide, 100, [2, 0, 2])->extract());
// NULL

?>

<?php

function getUser($username): Maybe {
  return $username == 'john.doe' ? just('John Doe') : nothing();
}

var_dump(just('john.doe')->map('getUser'));
// object(Monad\Maybe\Just)#7 (1) {
//     ["value":protected]=> object(Monad\Maybe\Just)#6 (1) {
//         ["value":protected]=> string(8) "John Doe"
//     }
// }

var_dump(just('jane.doe')->map('getUser'));
// object(Monad\Maybe\Just)#8 (1) {
//     ["value":protected]=> object(Monad\Maybe\Nothing)#6 (0) { }
// }

?>

<?php

var_dump(just('john.doe')->bind('getUser'));
// object(Monad\Maybe\Just)#6 (1) {
//     ["value":protected]=> string(8) "John Doe"
// }

var_dump(just('jane.doe')->bind('getUser'));
// object(Monad\Maybe\Nothing)#8 (0) { }

?>
