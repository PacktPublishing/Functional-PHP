<?php

function throw_exception()
{
    throw new Exception('Message');
}

function some_function($x)
{
    $y = throw_exception();
    try {
        $z = $x + $y;
    } catch(Exception $e) {
        $z = 42;
    }

    return $z;
}

echo some_function(42);
// PHP Warning: Uncaught Exception: Message

?>

<?php

try {
    $z = $x + throw_exception();
} catch(Exception $e) {
    $z = 42;
}

?>

<?php

class A {}

$a = new A();

$a->invalid_method();
// PHP Warning: Uncaught Error: Call to undefined method A::invalid_method()

?>

<?php

class B {}

$a = new B();

try {
    $a->invalid_method();
} catch(Error $e) {
    echo "An error occured : ".$e->getMessage();
}
// An error occured : Call to undefined method B::invalid_method()


?>

<?php

function add(int $a, int $b): int
{
    return $a + $b;
}

try {
    add(10, 'foo');
} catch(TypeError $e) {
    echo "An error occured : ".$e->getMessage();
}
// An error occured : Argument 2 passed to add() must be of the type integer, string given


?>
