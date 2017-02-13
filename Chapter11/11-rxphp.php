<?php

use \Rx\React\FromFileObservable;
use \Rx\Observer\CallbackObserver;

$data = new FromFileObservable("11-example.csv");

$data = $data
    ->cut()
    ->map('str_getcsv')
    ->map(function (array $row) { return $row; });

$data->subscribe(new CallbackObserver(
    function ($data) { echo $data[0]."\n"; },
    function ($e) { echo "error\n"; },
    function () { echo "done\n"; }
));

?>

<?php

$client = new PgAsync\Client([ "user" => "user", "database" => "db" ]);

$client->query('SELECT * FROM my_table')->subscribe(new CallbackObserver(
    function ($row) { },
    function ($e) { },
    function () { }
));

?>

<?php

use \React\EventLoop\StreamSelectLoop;
use \Rx\Observable;
use \Rx\Scheduler\EventLoopScheduler;

// Those are needed in order to create a timed interval
$loop = new StreamSelectLoop();
$scheduler  = new EventLoopScheduler($loop);

// This will emit an infinite sequence of growing integer every 50ms.
$source = Observable::interval(50, $scheduler);

$first = $source
    ->throttle(150, $scheduler) // do not emit more than one item per 150ms
    ->filter(function($i) { return $i % 2 == 0; }) // keep only odd numbers
    ->bufferWithCount(3) // buffer 3 items together before emitting them
    ->take(3); // take the 10 first items only

$second = $source
    ->throttle(150, $scheduler)
    ->take(10);

$first->merge($second) // merge both observable
    ->subscribe(new CallbackObserver(
        function ($i) { var_dump($i); },
        function ($e) { },
        function () { }
    ));

$loop->run();

?>
