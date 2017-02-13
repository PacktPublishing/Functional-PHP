<?php

function add(int $a, int $b): int
{
    return $a + $b;
}

?>

<?php

// let's assume Session is a class giving access
// to the $_SESSION variable.
function nextMessage(): string
{
    return Session::pop('message');
}

// A simple score updating method for a game
function updateScore(Player $player, int $points)
{
    $score = $player->getScore();
    $player->setScore($score + $points);
}

 ?>

<?php

function getCurrentTvProgram(Channel $channel): string
{
    // let's assume that getProgramAt is a pure method.
    return $channel->getProgramAt(time());
}

?>

<?php

function getTvProgram(Channel $channel, int $when): string
{
    return $channel->getProgramAt($when);
}

?>

<?php

$counter = 0;

function increment()
{
    global $counter;

    return ++$counter;
}

function increment2()
{
    static $counter = 0;

    return ++$counter;
}

function get_administrators(EntityManager $em)
{
    // Let's assume $em is a Doctrine EntityManager allowing
    // to perform DB queries
    return $em->createQueryBuilder()
              ->select('u')
              ->from('User', 'u')
              ->where('u.admin = 1')
              ->getQuery()->getArrayResult();
}

function get_roles(User $u)
{
    return array_merge($u->getRoles(), $u->getGroup()->getRoles());
}

?>

<?php

function set_administrator(EntityManager $em, User $u)
{
    $em->createQueryBuilder()
       ->update('models\User', 'u')
       ->set('u.admin', 1)
       ->where('u.id = ?1')
       ->setParameter(1, $u->id)
       ->getQuery()->execute();
}

function log_message($message)
{
    echo $message."\n";
}

function updatePlayers(Player $winner, Player $loser, int $score)
{
    $winner->updateScore($score);
    $loser->updateScore(-$score);
}

?>
