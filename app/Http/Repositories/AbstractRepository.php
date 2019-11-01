<?php
namespace App\Http\Repositories;

use App\Http\Contracts\RepositoryInterface;

abstract class AbstractRepository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->makeModel();
    }

    public function all($columns = ['*'])
    {
        return $this->model->get($columns);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $model = $this->find($id);
        $model->update($data);

        return $model;
    }

    public function delete($id)
    {
        $model = $this->find($id);
        return $model->delete();
    }

    public function find($id, $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    public function findBy($field, $value, $columns = ['*'])
    {
        return $this->model->where($field, '=' ,$value)->get($columns);
    }

    public abstract function model();

    public function makeModel()
    {
        $class = $this->model();
        $this->model = new $class;

        return $this->model;
    }
}
