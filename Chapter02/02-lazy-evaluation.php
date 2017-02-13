<?php

function wait(int $value): int
{
    // let's imagine this is a function taking a while
    // to compute a value
    sleep(10);
    return $value;
}

function do_something(bool $a, int $b, int $c): int
{
    if($a) {
        return $b;
    } else {
        return $c;
    }
}

do_something(true, wait(10), wait(8));

?>

<?php

// 'wait' will never get called as those operators are short-circuit
$a = (false && wait(10));
$b = (true  || wait(10));
$c = (false and wait(10));
$d = (true  or  wait(10));

?>

<?php

($a && wait(10)) || wait(8);

?>

<?php

// let's imagine $blogs is a lazily evaluated collection
// containing all the blog posts of your application order by date
$posts = [ /* ... */ ];

// last 10 posts for the homepage
return $posts->reverse()->take(10);

// posts with tag 'functional php'
return $posts->filter(function($b) {
    return $b->tags->contains('functional-php');
})->all();

// title of the first post from 2014 in the category 'life'
return $posts->filter(function($b) {
    return $b->year == 2014;
})->filter(function($b) {
    return $b->category == 'life';
})->pluck('title')->first();
?>

<?php

function integers()
{
    $i = 0;
    while(true) yield $i++;
}

?>

<?php

$array = [1, 2, 3, 4, 5, 6 /* ... */];

// version 1
for($i = 0; $i < count($array); ++$i) {
    // do something with the array values
}

// version 2
$length = count($array);
for($i = 0; $i < $length; ++$i) {
    // do something with the array values
}

?>

<?php

$a = $foo * $bar + $u;
$b = $foo * $bar * $v;

?>

<?php

$tmp = $foo * $bar;
$a = $tmp + $u;
$b = $tmp * $v;

?>
