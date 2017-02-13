<?php

function searchDirectory($dir, $accumulator = []) {
    foreach (scandir($dir) as $path) {
        // Ignore hidden files, current directory and parent directory
        if(strpos($path, '.') === 0) {
            continue;
        }

        $fullPath = $dir.DIRECTORY_SEPARATOR.$path;

        if(is_dir($fullPath)) {
            $accumulator = searchDirectory($path, $accumulator);
        } else {
            $accumulator[] = $fullPath;
        }
    }

    return $accumulator;
}

?>

<?php

function hanoi(int $disc, string $source, string $destination, string $via)
{
    if ($disc === 1) {
        echo("Move a disc from the $source rod to the $destination rod\n");
    } else {
        // step 1 : move all discs but the first to the "via" rod
        hanoi($disc - 1, $source, $via, $destination);
        // step 2 : move the last disc to the destination
        hanoi(1, $source, $destination, $via);
        // step 3 : move the discs from the "via" rod to the destination
        hanoi($disc - 1, $via, $destination, $source);
    }
}

?>

Move a disc from the left rod to the right rod
Move a disc from the left rod to the middle rod
Move a disc from the right rod to the middle rod
Move a disc from the left rod to the right rod
Move a disc from the middle rod to the left rod
Move a disc from the middle rod to the right rod
Move a disc from the left rod to the right rod

<?php

function while_iterative()
{
    $result = 1;
    while($result < 50) {
        $result = $result * 2;
    }

    return $result;
}

function while_recursive($result = 1, $continue = true)
{
    if($continue === false) {
        return $result;
    }

    return while_recursive($result * 2, $result < 50);
}

?>

<?php

function for_iterative()
{
    $result = 5;

    for($i = 1; $i < 10; ++$i) {
        $result = $result * $i;
    }

    return $result;
}

function for_recursive($result = 5, $i = 1)
{
    if($i >= 10) {
        return $result;
    }

    return for_recursive($result * $i, $i + 1);
}

?>

<?php

function for_with_helper()
{
    $helper = function($result = 5, $i = 1) use(&$helper) {
        if($i >= 10) {
            return $result;
        }

        return $helper($result * $i, $i + 1);
    };

    return $helper();
}

?>
