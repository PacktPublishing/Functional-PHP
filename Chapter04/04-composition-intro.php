<?php

function safe_title(string $s)
{
    $safe = htmlspecialchars($s);
    return strtoupper($safe);
}

?>

<?php

function safe_title2(string $s)
{
    return strtoupper(htmlspecialchars($s));
}

?>

<?php

require_once __DIR__.'/vendor/autoload.php';

use function Functional\compose;

$safe_title2 = compose('htmlspecialchars', 'strtoupper');

?>

<?php

$titles = ['Firefly', 'Buffy the Vampire Slayer', 'Stargate Atlantis'];

$titles2 = array_map(function(string $s) {
    return strtoupper(htmlspecialchars($s));;
}, $titles);

$titles3 = array_map(compose('htmlspecialchars', 'strtoupper'), $titles);

?>

<?php

$titles4 = array_map(compose('htmlspecialchars', 'strtoupper', 'trim'), $titles);

?>
