<?php 
namespace App\Repositories;

abstract class BaseRepository {

    protected $model;

    /**
     * The relations to eager load.
     *
     * @var
     */
    protected $with = [];

    function __construct($model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->newQuery()->with($this->with)->get();
    }

    public function get($id,$fail=true)
    {
        if($fail)
        { 
            return $this->model->findOrFail($id);
        }
        return $this->model->find($id); 
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data, $attribute = "id")
    {
        return tap($this->model->find( $id))->update($data)->fresh();
    }

    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * Sets relations for eager loading.
     *
     * @param $relations
     * @return $this
     */
    public function with($relations)
    { 
        if (is_string($relations))
        {
            $this->with = explode(',', $relations);

            return $this;
        }

        $this->with = is_array($relations) ? $relations : [];

        return $this;
    }

    /**
     * Creates a new QueryBuilder instance including eager loads
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function query()
    {
        return $this->model->newQuery()->with($this->with);
    }
} 
