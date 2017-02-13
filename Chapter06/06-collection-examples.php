<?php

require_once('06-monadic_helpers.php');

use Monad\Collection;
use Functional as f;

$powerset = filterM(function($x) {
    return Collection::of([true, false]);
}, [1, 2, 3]);

print_r($powerset->extract());
// Array (
//     [0] => Array ( [0] => 1 [1] => 2 [2] => 3 )
//     [1] => Array ( [0] => 1 [1] => 2 )
//     [2] => Array ( [0] => 1 [1] => 3 )
//     [3] => Array ( [0] => 1 )
//     [4] => Array ( [0] => 2 [1] => 3 )
//     [5] => Array ( [0] => 2 )
//     [6] => Array ( [0] => 3 )
//     [7] => Array ( )
// )

?>

<?php

$a = Collection::of([1, 2, 3])->bind(function($x) {
    return [$x, -$x];
});
print_r($a->extract());
// Array (
//     [0] => 1
//     [1] => -1
//     [2] => 2
//     [3] => -2
//     [4] => 3
//     [5] => -3
// )

$b = $a->bind(function($y) {
    return $y > 0 ? [$y * 2, $y / 2] : $y;
});
print_r($b->extract());
// Array (
//     [0] => 2
//     [1] => 0.5
//     [2] => -1
//     [3] => 4
//     [4] => 1
//     [5] => -2
//     [6] => 6
//     [7] => 1.5
//     [8] => -3
// )

?>

<?php

class ChessPosition {
    public $col;
    public $row;

    public function __construct($c, $r)
    {
        $this->col = $c;
        $this->row = $r;
    }

    public function isValid(): bool
    {
        return ($this->col > 0 && $this->col < 9) &&
               ($this->row > 0 && $this->row < 9);
    }
}

function chess_pos($c, $r) { return new ChessPosition($c, $r); }

?>

<?php

function moveKnight(ChessPosition $pos): Collection
{
    return Collection::of(f\filter(f\invoke('isValid'), Collection::of([
        chess_pos($pos->col + 2, $pos->row - 1),
        chess_pos($pos->col + 2, $pos->row + 1),
        chess_pos($pos->col - 2, $pos->row - 1),
        chess_pos($pos->col - 2, $pos->row + 1),
        chess_pos($pos->col + 1, $pos->row - 2),
        chess_pos($pos->col + 1, $pos->row + 2),
        chess_pos($pos->col - 1, $pos->row - 2),
        chess_pos($pos->col - 1, $pos->row + 2),
    ])));
}

print_r(moveKnight(chess_pos(8,1))->extract());
// Array (
//     [0] => ChessPosition Object ( [row] => 2 [col] => 6 )
//     [1] => ChessPosition Object ( [row] => 3 [col] => 7 )
// )

?>

<?php

function moveKnight3($start): array
{
    return Collection::of($start)
        ->bind('moveKnight')
        ->bind('moveKnight')
        ->bind('moveKnight')
        ->extract();
}

function canReach($start, $end): bool
{
    return in_array($end, moveKnight3($start));
}

var_dump(canReach(chess_pos(6, 2), chess_pos(6, 1)));
// bool(true)

var_dump(canReach(chess_pos(6, 2), chess_pos(7, 3)));
// bool(false)

?>
