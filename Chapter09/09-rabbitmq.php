<?php

require_once './vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
list($queue, ,) = $channel->queue_declare($queue_name, false, false, false, false);

$fold_function = function($a, $b) {
    return $a + $b;
};

?>
