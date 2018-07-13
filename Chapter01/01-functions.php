<?php

function my_function($parameter, $second_parameter)
{
    // [...]
}

?>

<?php

class SomeClass
{
   private $some_property;

   // a public function
   public function some_function()
   {
       // [...]
   }

   // a protected static function
   static protected function other_function()
   {
       // [...]
   }
}

?>

<?php

$add = function(float $a, float $b): float {
    return $a + $b;
};
// since this is an assignment, you have to finish the statement with a semicolon


?>

<?php

$add(5, 10);

$sum = array_reduce([1, 2, 3, 4, 5], $add);

?>

<?php

$uppercase = array_map(function(string $s): string {
  return strtoupper($s);
}, ['hello', 'world']);

?>

<?php

function return_new_function()
{
  return function($a, $b, $c) { /* [...] */};
}


?>

<?php

$some_variable = 'value';

$my_closure = function() use($some_variable)
{
  // [...]
};

?>

<?php

$s = 'orange';

$my_closure = function() use($s) { echo $s; };

$my_closure(); // display 'orange'

$s = 'banana';

$my_closure(); // still display 'orange'

?>

<?php

class ThisBinding
{
    public function testing()
    {
        return function() {
            var_dump($this);
        };
    }
}

?>

<?php

class StaticFunction
{
    public function testing()
    {
        return (static function() {
            // no access to $this here
        });
    }
};

?>

<?php

class ObjectAsFunction
{
    private function helper(int $a, int $b): input
    {
        return $a + $b;
    }

    public function __invoke(int $a, int $b): input
    {
      return $this->helper($a, $b);
    }
}

$instance = new ObjectAsFunction();
$sum = $instance(5, 10);

?>

<?php

function test_callable(callable $callback) : callable {
    $callback();
    return function() {
        // [...]
    };
}

?>

<?php

// by name
$callback = 'strtoupper';
$callback('Hello World !');

class A {
    static function hello($name) { return "Hello $name !\n"; }
    function __invoke($name) { return self::hello($name); }
}

// array with class name and static method name
$callback = ['A', 'hello'];
$callback('World');

// string representing the class and method name
$callback = 'A::hello';
$callback('World');

$a = new A();

// array with instance and method name (static or not)
$callback = [$a, 'hello'];
$callback('World');

// object as a function
$callback = $a;
$callback('World');

// variable containing an anonymous function or closure
$callback = function(string $s)
{
    return "Hello $s !\n";
};
$callback('World');

// If you don't like calling the callback directly like
// above, you can also use `call_user_func_array` or
// `call_user_func` if you don't have parameters.
call_user_func_array($callback, ['World']);

?>
