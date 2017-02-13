<?php

function curry_n(int $count, callable $function): callable
{
    $accumulator = function(array $arguments) use($count, $function, &$accumulator) {
        return function() use($count, $function, $arguments, $accumulator) {
            $arguments = array_merge($arguments, func_get_args());

            if($count <= count($arguments)) {
                return call_user_func_array($function, $arguments);
            }

            return $accumulator($arguments);
        };
    };

    return $accumulator([]);
}

?>

<?php

function curry(callable $function, bool $required = true): callable
{
    if(is_string($function) && strpos($function, '::', 1) !== false) {
        $reflection = new \ReflectionMethod($f);
    } else if(is_array($function) && count($function) == 2) {
        $reflection = new \ReflectionMethod($function[0], $function[1]);
    } else if(is_object($function) && method_exists($function, '__invoke')) {
        $reflection = new \ReflectionMethod($function, '__invoke');
    } else {
        $reflection = new \ReflectionFunction($function);
    }

    $count = $required ?
        $reflection->getNumberOfRequiredParameters() :
        $reflection->getNumberOfParameters();

    return curry_n($count, $function);
}

?>
