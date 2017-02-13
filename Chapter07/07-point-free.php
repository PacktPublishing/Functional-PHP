<?php

use function Functional\compose;

?>

<?php

// traditional
function safe_title(string $s)
{
    return strtoupper(htmlspecialchars($s));
}

// point-free
$safe_title = compose('htmlspecialchars', 'strtoupper');

?>
