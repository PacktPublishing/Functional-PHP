<?php

function greet()
{
  $hour = (int) date('g');

  if ($hour >= 5 && $hour < 12) {
    return "Good morning!";
  } elseif ($hour < 18) {
    return "Good afternoon!";
  } elseif ($hour < 22) {
    return "Good evening!";
  }

  return "Good night!";
}

?>

<?php

function title(string $string): string
{
  $stripped = strip_tags($string);
  $trimmed = trim($stripped);
  return capitalize($trimmed);
}

?>
