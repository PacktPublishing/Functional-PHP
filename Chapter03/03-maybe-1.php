<?php

abstract class Maybe
{
    public static function just($value): Just
    {
        return new Just($value);
    }

    public static function nothing(): Nothing
    {
        return Nothing::get();
    }

    abstract public function isJust(): bool;

    abstract public function isNothing(): bool;

    abstract public function getOrElse($default);
}

?>

<?php

final class Just extends Maybe
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function isJust(): bool
    {
        return true;
    }

    public function isNothing(): bool
    {
        return false;
    }

    public function getOrElse($default)
    {
        return $this->value;
    }
}

?>

<?php

final class Nothing extends Maybe
{
    private static $instance = null;
    public static function get()
    {
        if(is_null(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function isJust(): bool
    {
        return false;
    }

    public function isNothing(): bool
    {
        return true;
    }

    public function getOrElse($default)
    {
        return $default;
    }
}

?>

<?php

$hello = Maybe::just("Hello World !");
$nothing = Maybe::nothing();

echo $hello->getOrElse("Nothing to see...");
// Hello World !
var_dump($hello->isJust());
// bool(true)
var_dump($hello->isNothing());
// bool(false)

echo $nothing->getOrElse("Nothing to see...");
// Nothing to see...
var_dump($nothing->isJust());
// bool(false)
var_dump($nothing->isNothing());
// bool(true)

 ?>
