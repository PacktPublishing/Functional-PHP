<?php

function max2(array $data): int
{
    return array_reduce($data, function(int $max, int $i) : int {
        return $i > $max ? $i : $max;
    }, 0);
}

?>

<?php

function max3(array $data)
{
    if(empty($data)) {
        trigger_error('max3(): Array must contain at least one element', E_USER_WARNING);
        return false;
    }

    return array_reduce($data, function(int $max, int $i) : int {
        return $i > $max ? $i : $max;
    }, 0);
}

?>

<?php

/* create a new cURL resource */
$ch = curl_init();

/* set URL and other appropriate options */
curl_setopt($ch, CURLOPT_URL, "http://www.example.com/");
curl_setopt($ch, CURLOPT_HEADER, 0);

/* grab URL and pass it to the browser */
curl_exec($ch);

/* close cURL resource, and free up system resources */
curl_close($ch);

?>

<?php

function max4(array $data, int $default = 0): int
{
    return empty($data) ? $default :
      array_reduce($data, function(int $max, int $i) : int {
          return $i > $max ? $i : $max;
      }, 0);
}

?>

<?php

function max5(array $data, callable $onError): int
{
    return empty($data) ? $onError() :
      array_reduce($data, function(int $max, int $i) : int {
          return $i > $max ? $i : $max;
      }, 0);
}

max5([], function(): int {
    // You are free to do anything you want here.
    // Not really useful in such a simple case but
    // when creating complex objects it can prove invaluable.
    return 42;
});

?>
