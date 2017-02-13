<?php

function add(float $a, int $b): float {
    return $a + $b;
}

echo add(3.5, 1);
// 4.5
echo add(3, 1);
// 4
echo add("3.5", 1);
// 4.5
echo add(3.5, 1.2); // 1.2 gets casted to 1
// 4.5
echo add("1 week", 1); // "1 week" gets casted to 1.0
// PHP Notice:  A non well formed numeric value encountered
// 2
echo add("some string", 1);
// Uncaught TypeError Argument 1 passed to add() must be of the type float, string given

function test_bool(bool $a): string {
    return $a ? 'true' : 'false';
}

echo test_bool(true);
// true
echo test_bool(false);
// false
echo test_bool("");
// false
echo test_bool("some string");
// true
echo test_bool(0);
// false
echo test_bool(1);
// true
echo test_bool([]);
// Uncaught TypeError: Argument 1 passed to test_bool() must be of the type boolean
