<?php

$numerals = [1, 2, 3, 4];
$english = ['one', 'two'];
$french = ['un', 'deux', 'trois'];

print_r(array_map(null, $numerals, $english, $french));

?>

Array
(
    [0] => Array
        (
            [0] => 1
            [1] => one
            [2] => un
        )
    [1] => Array
        (
            [0] => 2
            [1] => two
            [2] => deux
        )
    [2] => Array
        (
            [0] => 3
            [1] =>
            [2] => trois
        )
    [3] => Array
        (
            [0] => 4
            [1] =>
            [2] =>
        )
)

<?php

function unzip(array $data): array
{
    $return = [];

    $data = array_values($data);
    $size = count($data[0]);

    foreach($data as $child) {
        $child = array_values($child);
        for($i = 0; $i < $size; ++$i) {
            if(isset($child[$i]) && $child[$i] !== null) {
                $return[$i][] = $child[$i];
            }
        }
    }

    return $return;
}

?>

<?php

$zipped = array_map(null, $numerals, $english, $french);

list($numerals2, $english2, $french2) = unzip($zipped);

var_dump($numerals == $numerals2);
// bool(true)
var_dump($english == $english2);
// bool(true)
var_dump($french == $french2);
// bool(true)

?>
