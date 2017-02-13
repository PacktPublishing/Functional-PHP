<?php

use Monad\State as s;
use Functional as f;

?>

<?php

function randomInt()
{
    return s\state(function($state) {
        mt_srand($state);
        return [mt_rand(), mt_rand()];
    });
}

echo s\evalState(randomInt(), 12345);
// 162946439

?>

<?php

function getUser($id, $current = [])
{
    return f\curryN(2, function($id, $current) {
        return s\state(function($cache) use ($id, $current) {
            if(! isset($cache[$id])) {
                $cache[$id] = "user #$id";
            }

            return [f\append($current, $cache[$id]), $cache];
        });
    })(...func_get_args());
}

list($users, $cache) = s\runState(
  getUser(1, [])
    ->bind(getUser(2))
    ->bind(getUser(1))
    ->bind(getUser(3)),
  []
);

print_r($users);
// Array (
//     [0] => user #1
//     [1] => user #2
//     [2] => user #1
//     [3] => user #3
// )


print_r($cache);
// Array (
//     [1] => user #1
//     [2] => user #2
//     [3] => user #3
// )

?>
