<?php

namespace Monad;

use Common;
use FantasyLand\Apply;
use FantasyLand\Monad;
use FantasyLand\Monoid;
use FantasyLand\Semigroup;

class StringMonoid implements Monoid
{
    private $value;
    public function __construct($s) {
        $this->value = $s;
    }

    public function getEmpty() {
        return '';
    }

    public function get() {
        return $this->value;
    }

    public function concat(Semigroup $value) {
        return new static($this->value . $value->get());
    }
}

?>

<?php

class Writer implements Monad
{
    const of = 'Monad\Writer::of';

    use Common\PointedTrait;

    /** @var Monoid $side */
    private $side;

    public function __construct($value, $side = '')
    {
        $this->value = $value;

        if(is_string($side)) {
            $this->side = new StringMonoid($side);
        } else if($side instanceof Monoid) {
            $this->side = $side;
        } else {
            throw new RuntimeException("String or Monoid needed.");
        }
    }

    public function bind(callable $function)
    {
        $new = $function($this->value);
        $new->side = $this->side->concat($new->side);

        return new static($new->value, $new->side);
    }

    public function ap(Apply $b)
    {
        $value = $b->map($this->value);
        $side = $b instanceof Writer ? $this->side->concat($b->side) : $this->side;

        return new static($value, $side);
    }

    public function map(callable $function)
    {
        return new static($function($this->value), $this->side);
    }

    public function runWriter()
    {
        return [$this->value, $this->side];
    }
}

?>
