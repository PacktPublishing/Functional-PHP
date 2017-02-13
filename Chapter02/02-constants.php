<?php

define('FOO', 'something');
const BAR = 42;

// this only works since PHP 5.6
const BAZ = ['one', 'two', 'three'];

// the 'define' syntax for array work since PHP 7
define('BAZ7', ['one', 'two', 'three']);

// names starting and ending with underscores are discouraged
define('__FOO__', 'possible clash');

?>

<?php

define('UPPERCASE', strtoupper('Hello World !'));

?>

<?php

echo UPPERCASE;
// display 'HELLO WORLD !'

echo I_DONT_EXISTS;
// PHP Notice:  Use of undefined constant I_DONT_EXISTS - assumed 'I_DONT_EXISTS'
// display 'I_DONT_EXISTS' anyway

?>

<?php

echo constant('UPPERCASE');
// display 'HELLO WORLD !'

echo defined('UPPERCASE') ? 'true' : 'false';
// display 'true'

echo constant('I_DONT_EXISTS');
// PHP Warning:  constant(): Couldn't find constant I_DONT_EXISTS
// display nothings as 'constant' returns 'null' in this case

echo defined('I_DONT_EXISTS') ? 'true' : 'false';
// display 'false'

?>

<?php

class A
{
    const FOO = 'some value';

    public static function bar()
    {
        echo self::FOO;
    }
}

echo A::FOO;
// display 'some value'

echo constant('A::FOO');
// display 'some value'

echo defined('A::FOO') ? 'true' : 'false';
// display 'true'

A::bar();
// display 'some value'

?>

<?php

const FOO = 6;

class B
{
    const BAR = FOO * 7;
    const BAZ = "The answer is ".self.BAR;
}

?>

<?php

const FOO = 'foo';
$bar = 'bar';

function test()
{
    // here FOO is accessible
    echo FOO;

    // however, if you want to access $bar, you have to use
    // the 'global' keyword.
    global $bar;
    echo $bar;
}

?>
