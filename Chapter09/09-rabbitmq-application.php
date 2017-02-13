<?php

use PhpAmqpLib\Message\AMQPMessage;

$queue_name = '';
require_once('09-rabbitmq.php');

function send($channel, $queue, $chunk, $initial)
{
    $data = [
        'collection' => $chunk,
        'initial' => $initial
    ];
    $msg = new AMQPMessage(serialize($data), array('reply_to' => $queue));
    $channel->basic_publish($msg, '', 'fold_queue');
}

class Results {
    private $results = [];
    private $channel;

    public function register($channel, $queue)
    {
        $this->channel = $channel;
        $channel->basic_consume($queue, '', false, false, false, false, [$this, 'process']);
    }

    public function process($rep)
    {
        $this->results[] = unserialize($rep->body);
    }

    public function get($expected)
    {
        while(count($this->results) < $expected) {
            $this->channel->wait();
        }

        return $this->results;
    }
}

$results = new Results();
$results->register($channel, $queue);

$initial = 0;

send($channel, $queue, [1, 2, 3], 0);
send($channel, $queue, [4, 5, 6], 0);
send($channel, $queue, [7, 8, 9], 0);
send($channel, $queue, [10], 0);

echo array_reduce($results->get(4), $fold_function, $initial);
// 55

?>
