<?php

use PhpAmqpLib\Message\AMQPMessage;

$queue_name = 'fold_queue';
require_once('09-rabbitmq.php');

function callback($r) {
    global $fold_function;

    $data = unserialize($r->body);

    $result = array_reduce($data['collection'], $fold_function, $data['initial']);

    $msg = new AMQPMessage(serialize($result));

    $r->delivery_info['channel']->basic_publish($msg, '', $r->get('reply_to'));
    $r->delivery_info['channel']->basic_ack($r->delivery_info['delivery_tag']);
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('fold_queue', '', false, false, false, false, 'callback');

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

?>
