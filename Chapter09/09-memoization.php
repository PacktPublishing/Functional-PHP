<?php

function long_computation($n)
{
    static $cache = [];
    $key = md5(serialize($n));

    if(! isset($cache[$key])) {
        // your computation comes here, the rest is boilerplate
        sleep(2);
        $cache[$key] = $n;
    }

    return $cache[$key];
}

?>
