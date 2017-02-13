<?php


class Message
{
    private $message;
    private $status;

    public function __construct(string $message, string $status)
    {
        $this->status = $status;
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function equals($m)
    {
        return $m->status === $this->status && $m->message === $this->message;
    }

    public function withStatus($status): Message
    {
        $new = clone $this;
        $new->status = $status;
        return $new;
    }
}

?>
