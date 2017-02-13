<?php

// The Player implementation is voluntarily simple for brevity.
// Obviously you would use immutable.php in a real project.
class Player
{
    public $hp;
    public $x;
    public $y;

    public function __construct(int $x, int $y, int $hp) {
        $this->x = $x;
        $this->y = $y;
        $this->hp = $hp;
    }
}

function isCloseEnough(Player $one, Player $two): boolean
{
    return abs($one->x - $two->x) < 2 &&
           abs($one->y - $two->y) < 2;
}

function loseHitpoint(Player $p): Player
{
    return new Player($p->x, $p->y, $p->hp - 1);
}

function hit(Player $p, Player $target): Player
{
    return isCloseEnough($p, $target) ?
        loseHitpoint($target) :
        $target;
}

?>

<?php

$john = new Player(8, 8, 10);
$ted  = new Player(7, 9, 10);

$ted = hit($john, $ted);

?>

<?php

return abs($p->x - $target->x) < 2 && abs($p->y - $target->y) < 2 ?
    loseHitpoint($target) :
    $target;

?>

<?php

return abs(8 - 7) < 2 && abs(8 - 8) < 2 ?
    loseHitpoint($target) :
    $target;

?>

<?php

return 1 < 2 && 0 < 2 ?
    loseHitpoint($target) :
    $target;
?>

<?php

return loseHitpoint($target);

?>

<?php

return new Player($target->x, $target->y, $target->hp - 1);

?>

<?php

return new Player(8, 7, 10 - 1);

?>

<?php

$ted = new Player(8, 7, 9);

?>
