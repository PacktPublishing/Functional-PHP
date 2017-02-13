<?php

require_once __DIR__.'/vendor/autoload.php';

use function Functional\map;

map(range(0, 4), function($v) { return $v * 2; });

use Functional as F;

F\map(range(0, 4), function($v) { return $v * 2; });

?>
