<?php

namespace App\Repositories\Eloquents;

use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class Repository implements RepositoryInterface
{
    protected $model;
    protected $modelName;

    public function __construct($modelName)
    {
        $this->modelName = $modelName;
        $this->makeModel();
    }

    protected function makeModel()
    {
        return $this->model = new $this->modelName;
    }

    public function findOrFail($id, $columns = array('*'))
    {
        return $this->model->findOrFail($id, $columns);
    }

    public function all($columns = array('*'))
    {
        return $this->model->all($columns);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        $model = $this->findOrFail($id);
        $model->update($data);

        return $model;
    }

    public function delete($id)
    {
        return $this->findOrFail($id)->delete();
    }

    public function destroy($ids) {
        return $this->model->destroy($ids);
    }
}
