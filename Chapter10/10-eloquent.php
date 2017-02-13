<?php

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    private $status;
    private $publicationDate;

    public function publish(DateTime $d)
    {
        $new = clone $this;

        $new->status = 'published';
        $new->publicationDate = $d;
        return $new;
    }
}

?>

<?php

use Illuminate\Database\Eloquent\Builder as BaseBuilder;
use Widmogrod\Monad\Maybe as m;

class FunctionalBuilder extends BaseBuilder
{
    public function first($columns = array('*'))
    {
        return m\maybeNull(parent::first($columns));
    }

    public function firstOrFail($columns = array('*'))
    {
        return $this->first($columns)->orElse(function() {
            throw (new ModelNotFoundException)->setModel(get_class($this->model));
        });
    }

    public function findOrFail($id, $columns = array('*'))
    {
        return $this->find($id, $columns)->orElse(function() {
            throw (new ModelNotFoundException)->setModel(get_class($this->model));
        });
    }

    public function pluck($column)
    {
        return $this->first([$column])->map(function($result) {
            return $result->{$column};
        });
    }
}

?>

<?php

use Illuminate\Database\Eloquent\Model as BaseModel;

class FunctionalModel extends BaseModel
{
    public function newEloquentBuilder($query)
    {
        return new FunctionalBuilder($query);
    }
}

?>
