<?php

function excerpt(string $s)
{
    return substr($s, 0, 5);
}

echo excerpt('Lorem ipsum dolor si amet.');
// Lorem

?>

<?php

use function Functional\partial_right;
use function Functional\partial_left;
use function Functional\partial_any;
use const Functional\…;

$excerpt = partial_right('substr', 0, 5);
echo $excerpt('Lorem ipsum dolor si amet.');
// Lorem

$fixed_string = partial_left('substr', 'Lorem ipsum dolor si amet.');
echo $fixed_string(6, 5);
// ipsum

$start_placeholder = partial_any('substr', 'Lorem ipsum dolor si amet.', …(), 5);
echo $start_placeholder(12);
// dolor

?>
