<?php

use FunctionalPHP\PatternMatching as m;

$users = [
    [ 'name' => 'Gilles', 'status' => 10 ],
    [ 'name' => 'John', 'status' => 5 ],
    [ 'name' => 'Ben', 'status' => 0],
    [],
    'some random string'
];

$statuses = array_map(m\match([
    '[_, 10]' => function() { return 'admin'; },
    '[_, 5]' => 'moderator',
    '[_, _]' => 'normal user',
    '_' => 'n/a',
]), $users);

print_r($statuses);
// Array (
//    [0] => admin
//    [1] => moderator
//    [2] => normal user
//    [3] => n/a
//    [4] => n/a
// )

?>

<?php

$group_names = [ 10 => 'admin', 5 => 'moderator' ];

$statuses = array_map(m\match([
    '[name, s]' => function($name, $s) use($group_names) {
        return $name.
               ' - '.
               (isset($group_names[$s]) ? $group_names[$s] : 'normal user');
    },
    '[]' => 'incomplete array',
    '_' => 'n/a',
]), $users);

print_r($statuses);
// Array (
//    [0] => admin
//    [1] => moderator
//    [2] => normal user
//    [3] => incomplete array
//    [4] => n/a
// )

?>

<?php

$url = 'user/10';

function homepage() { return "Hello!"; }
function user($id) { return "user $id"; }
function add_user_to_group($group, $user) { return "done."; }

$result = m\match([
    '["user", id]' => 'user',
    '["group", group, "add", user]' => 'add_user_to_group',
    '_' => 'homepage',
], explode('/', $url));

echo $result;
// user 10

?>

<?php

$data = [
  'Gilles',
  ['Some street', '12345', 'Some City'],
  'xxx xx-xx-xx',
  ['admin', 'staff'],
  ['username' => 'gilles', 'password' => '******'],
  [12, 34, 53, 65, 78, 95, 102]
];

print_r(m\extract('[name, _, phone, groups, [username, _], posts@(first:_)]', $data));
// Array (
//    [name] => Gilles
//    [phone] => xxx xx-xx-xx
//    [groups] => Array ( [0] => admin [1] => staff )
//    [username] => gilles
//    [posts] => Array ( ... )
//    [first] => 12
//)

?>

<?php

$fact = m\func([
    '0' => 1,
    'n' => function($n) use(&$fact) {
        return $n * $fact($n - 1);
    }
]);

?>
