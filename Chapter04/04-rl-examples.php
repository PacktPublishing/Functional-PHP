<?php

class User {
    public function phone(): string
    {
        return '';
    }

    public function registration_date(): DateTime
    {
        return new DateTime();
    }
}

$users = [new User(), new User(), new User()]; // etc.

?>

<?php

function getLastMonthUserPhones($users)
{
    $limit = (new DateTime("-30 days"))->getTimestamp();
    $return = [];
    foreach($users as $u) {
        if($u->registration_date()->getTimestamp() > $limit) {
            $return[] = $u->phone();
        }
    }
    return $return;
}

?>

<?php

function getUserPhonesFromDate($limit, $users)
{
    return array_map(function(User $u) {
        return $u->phone();
    }, array_filter($users, function(User $u) use($limit) {
        return $u->registration_date()->getTimestamp() > $limit;
    }));
}

?>

<?php

use function Functional\map;
use function Functional\filter;
use function Functional\partial_method;

function getUserPhonesFromDate2($limit, $users)
{
    return map(
        filter(function(User $u) use($limit) {
            return $u->registration_date()->getTimestamp() > $limit;
        }, $users),
        partial_method('phone')
    );
}

?>

<?php

function greater($limit) {
    return function($a) {
        return $a > $limit;
    };
}

function getUserPhonesFromDate3($limit, $users)
{
    return map(
        filter(compose(
            partial_method('registration_date'),
            partial_method('getTimestamp'),
            greater($limit)
          ),
          $users),
        partial_method('phone')
    );
}

?>

<?php

require('04-curry.php');

?>

<?php

use function Functional\partial_right;

$filter = curry('filter');
$map = function($cb) {
    return function($data) use($cb) {
        return map($data, $cb);
    };
};

function getPhonesFromDate($limit)
{
    return function($data) use($limit) {
        $function = compose(
            $filter(compose(
            partial_method('getTimestamp'),
                partial_method('registration_date'),
                greater($limit)
            )),
            $map(partial_method('phone'))
        );
        return $function($data);
    };
}

?>

<?php

use function Functional\sort;
use function Functional\compare_on;

function take(int $count) {
    return function($array) use($count) {
        return array_slice($array, 0, $count);
    };
};

function compare($a, $b) {
    return $a == $b ? 0 : $a < $b ? -1 : 1;
}

function getAtMostThreeFromDate($limit)
{
    return function($data) use($limit) {
        $function = compose(
            partial_right(
                'sort',
                compare_on('compare', partial_method('registration_date'))
            ),
            take(3),
            getPhonesFromDate($limit)
        );
        return $function($data);
    };
}

?>
