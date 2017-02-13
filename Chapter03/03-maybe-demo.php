<?php
/* The following code is not included in the book, it is
   is here so that the tool used to generate the code samples
   does not complains about non existing variables. */

require_once __DIR__.'/03-maybe-final.php';

function getCurrentUser() { return new User(); }
class User { public $name = 'John'; }
class AnonymousUser { public $name = 'Guest'; }

?>

<?php

$user = getCurrentUser();

$name = $user == null ? 'Guest' : $user->name;

echo sprintf("Welcome %s", $name);
// Welcome John

?>

<?php

$user = getCurrentUser();

if($user == null) {
   $user = new AnonymousUser();
}

echo sprintf("Welcome %s", $user->name);
// Welcome John

?>

<?php

$user = Maybe::fromValue(getCurrentUser());

$name = $user->map(function(User $u) {
  return $u->name;
})->getOrElse('Guest');

echo sprintf("Welcome %s", $name);
// Welcome John

echo sprintf("Welcome %s", $user->getOrElse(new AnonymousUser())->name);
// Welcome John

?>

<?php
/* The following code is not included in the book, it is
   is here so that the tool used to generate the code samples
   does not complains about non existing variables. */
function getDashboard() { return Maybe::just('dashboard'); }
function getGroupDashboard() { return Maybe::nothing(); }
function getUserDashboard() { return Maybe::nothing(); }

?>

<?php

$dashboard = getUserDashboard();
if($dashboard == null) {
    $dashboard = getGroupDashboard();
}
if($dashboard == null) {
    $dashboard = getDashboard();
}

?>

<?php

/* We assume the dashboards method now return Maybe instances */
$dashboard = getUserDashboard()
             ->orElse(getGroupDashboard())
             ->orElse(getDashboard());

?>

<?php

$num = Maybe::fromValue(42);

$val = $num->map(function($n) { return $n * 2; })
         ->filter(function($n) { return $n < 80; })
         ->map(function($n) { return $n + 10; })
         ->orElse(Maybe::fromValue(99))
         ->map(function($n) { return $n / 3; })
         ->getOrElse(0);
echo $val;
// 33

?>
