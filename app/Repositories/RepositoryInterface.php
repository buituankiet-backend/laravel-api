<?php

namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get all
     * @return mixed
     */
    public function getAll($request);

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($model);

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, array $attributes);

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id);
}
