<?php

require_once('09-performance.php');
use Oefenweb\Statistics\Statistics;

?>

<?php

function benchmark($function, $params, $expected)
{
    $iteration   = 10;
    $computation = 2000000;

    $times = array_map(function() use($computation, $function, $params, $expected) {
        $start = microtime(true);

        array_reduce(range(0, $computation), function($expected) use ($function, $params) {
            if(($res = call_user_func_array($function, $params)) !== $expected) {
                throw new RuntimeException("Faulty computation");
            }

            return $expected;
        }, $expected);

        return microtime(true) - $start;
    }, range(0, $iteration));

    echo sprintf("mean: %02.3f seconds\n", Statistics::mean($times));
    echo sprintf("std:  %02.3f seconds\n", Statistics::standardDeviation($times));
}

?>

<?php

benchmark('add', [21, 33], 54);
// mean: 0.447 seconds
// std:  0.015 seconds

benchmark('manualCurryAdd', [21, 33], 54);
// mean: 1.210 seconds
// std:  0.016 seconds

benchmark($curryiedAdd, [21, 33], 54);
// mean: 1.476 seconds
// std:  0.007 seconds

?>

<?php

benchmark('add4', [10], 14);
// mean: 0.434 seconds
// std:  0.001 seconds

benchmark($composedAdd4, [10], 14);
// mean: 1.362 seconds
// std:  0.005 seconds

benchmark($composerCurryedAdd, [10], 14);
// mean: 3.555 seconds
// std:  0.018 seconds

?>

<?php

benchmark([new Adder, 'add'], [new Integer(21), new Integer(33)], 54);
// mean: 0.767 seconds
// std:  0.019 seconds

?>
