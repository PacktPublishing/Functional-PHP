<?php

require_once('./vendor/autoload.php');

?>

<?php

class Folder extends Thread {
    private $collection;
    private $callable;
    private $initial;

    private $results;

    private function __construct($callable, $collection, $initial)
    {
        $this->callable = $callable;
        $this->collection = $collection;
        $this->initial = $initial;
    }

    public function run()
    {
        $this->results = array_reduce($this->collection, $this->callable, $this->initial);
    }

    public static function fold($callable, array $collection, $initial, $threads=4)
    {
        $chunks = array_chunk($collection, ceil(count($collection) / $threads));

        $threads = array_map(function($i) use ($chunks, $callable, $initial) {
            $t = new static($callable, $chunks[$i], $initial);
            $t->start();
            return $t;
        }, range(0, $threads - 1));

        $results = array_map(function(Thread $t) {
            $t->join();
            return $t->results;
        }, $threads);

        return array_reduce($results, $callable, $initial);
    }
}

?>

<?php

$add = function($a, $b) {
    return $a + $b;
};

$collection = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

echo Folder::fold($add, $collection, 0);
// 55

?>
