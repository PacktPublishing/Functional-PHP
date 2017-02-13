<?php

class BlogPost
{
    private $status;
    private $publicationDate;

    public function setStatus(string $s)
    {
        $this->status = $s;
    }

    public function setPublicationDate(DateTime $d)
    {
        $this->publicationDate = $d;
    }
}

?>

<?php

class BlogPost2
{
    private $status;
    private $publicationDate;

    public function publish(DateTime $d)
    {
        $this->status = 'published';
        $this->publicationDate = $d;
    }
}

?>

<?php

$date = $post->getPublicationDate();

// for any reason you modify the date
$date->modify('+14 days');

var_dump($post->getPublicationDate() == $date);
// bool(true)

$entityManager->persist($post);
$entityManager->flush();
// nothing changes in the database :(

?>

<?php

use Widmogrod\Monad\Maybe as m;
use Widmogrod\Monad\Collection;

class FunctionalEntityRepository extends EntityRepository
{
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return m\maybeNull(parent::find($id, $lockMode, $lockVersion));
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return m\maybeNull(parent::findOneBy($criteria, $orderBy));
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return Collection::of(parent::findBy($criteria, $orderBy, $limit, $offset));
    }

    public function findAll()
    {
        return Collection::of(parent::findAll());
    }
}

?>
