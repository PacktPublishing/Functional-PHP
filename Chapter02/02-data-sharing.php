<?php

// let's assume we have some big array of data
$array = ['one', 'two', 'three', '...'];

$filtered = array_filter($array, function($i) { /* [...] */ });
$beginning = array_slice($array, 0, 10);
$final = array_map(function($i) { /* [...] */ }, $array);

?>
