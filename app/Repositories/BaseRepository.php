<?php

namespace App\Repositories;

use App\Exceptions\GeneralJsonException;
use App\Repositories\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function getAll($pageSize)
    {
        return $this->model->paginate($pageSize);
    }

    public function find($id)
    {
        $result = $this->model->find($id);

        throw_if(!$result, GeneralJsonException::class, 'Not found', 400);

        return $result;
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes){
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();
            return true;
        }

        return false;
    }
}