<?php

// traditional function declaration
function my_function(int $one, bool $two): string
{
    // [...]
}

// anonymouse function
$my_function = function(int $one, bool $two): string
{
    // [...]
};

// closure
$some_variable = 'value';

$my_function = function(int $one, bool $two) use($some_variable) : string
{
    // [...]
};

// object as a function
class Test
{
    public function __invoke(int $one, bool $two): string
    {
        // [...]
    }
}

?>
