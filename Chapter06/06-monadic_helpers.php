<?php

use function Functional\head;
use function Functional\tail;

use Monad\Writer;

function filterM(callable $f, $collection)
{
    $monad = $f(head($collection));

    $_filterM = function($collection) use($monad, $f, &$_filterM){
        if(count($collection) == 0) {
            return $monad->of([]);
        }

        $x = head($collection);
        $xs = tail($collection);

        return $f($x)->bind(function($bool) use($x, $xs, $monad, $_filterM) {
            return $_filterM($xs)->bind(function(array $acc) use($bool, $x, $monad) {
                if($bool) {
                    array_unshift($acc, $x);
                }

                return $monad->of($acc);
            });
        });
    };

    return $_filterM($collection);
}

?>

<?php

function foldM(callable $f, $initial, $collection)
{
    $monad = $f($initial, head($collection));

    $_foldM = function($acc, $collection) use($monad, $f, &$_foldM){
        if(count($collection) == 0) {
            return $monad->of($acc);
        }

        $x = head($collection);
        $xs = tail($collection);

        return $f($acc, $x)->bind(function($result) use($acc, $xs, $_foldM) {
            return $_foldM($result, $xs);
        });
    };

    return $_foldM($initial, $collection);
}

?>
