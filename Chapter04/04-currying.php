<?php

function substr_curryied(string $s)
{
    return function(int $start) use($s) {
        return function(int $length) use($s, $start) {
            return substr($s, $start, $length);
        };
    };
}

$f = substr_curryied('Lorem ipsum dolor sit amet.');
$g = $f(0);
echo $g(5);
// Lorem

?>

<?php

echo substr_curryied('Lorem ipsum dolor sit amet.')(0)(5);
// Lorem

?>

<?php

function pluck(string $property)
{
    return function($o) use($property) {
        if (is_object($o) && isset($o->{$propertyName})) {
            return $o->{$property};
        } elseif ((is_array($o) || $o instanceof ArrayAccess) && isset($o[$property])) {
            return $o[$property];
        }

        return false;
    };
}

?>

<?php

$user = ['name' => 'Gilles', 'country' => 'Switzerland', 'member' => true];
pluck('name')($user);

?>

<?php

$users = [
    ['name' => 'Gilles', 'country' => 'Switzerland', 'member' => true],
    ['name' => 'Léon', 'country' => 'Canada', 'member' => false],
    ['name' => 'Olive', 'country' => 'England', 'member' => true],
];
pluck('country')($users);

?>

<?php

array_filter($users, pluck('member'));

?>

<?php

pluck('name', array_filter($users, pluck('member')));

?>

<?php

function map(callable $callback)
{
    return function(array $array) use($callback) {
        return array_map($callback, $array);
    };
}

function replace($regex)
{
    return function(string $replacement) use($regex) {
        return function(string $subject) use($regex, $replacement) {
            return preg_replace($regex, $replacement, $subject);
        };
    };
}

?>

<?php

$space2underscore = map(replace('/\s/i')('_'));
print_r($space2underscore(['Hello world!', 'How are you ?']));
// Array
// (
// [0] => Hello_world!
// [1] => How_are_you_?
// )

$replaceVowels = replace('/[aeiouy]/i');
$vowels2star = $replaceVowels('*');
echo $vowels2star('Functional programming');
// F*nct**n*l pr*gr*mm*ng

?>
