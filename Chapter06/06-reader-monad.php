<?php

namespace Monad;

use FantasyLand\Apply;
use FantasyLand\Monad;

class Reader implements Monad
{
    const of = 'Monad\Reader::of';

    use \Common\PointedTrait;

    public function bind(callable $function)
    {
        return self::of(function ($env) use ($function) {
            return $function($this->runReader($env))->runReader($env);
        });
    }

    public function ap(Apply $b)
    {
        return $b->bind(function($f) {
            return $this->map($f);
        });
    }

    public function map(callable $function)
    {
        return self::of(function ($env) use ($function) {
            return $function($this->runReader($env));
        });
    }


    public function runReader($env)
    {
        return call_user_func($this->value, $env);
    }
}

?>
