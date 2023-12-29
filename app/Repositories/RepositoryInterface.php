<?php

namespace App\Repositories;

/**
 * RepositoryInterface for using with repository pattern
 * 27/12/2023
 * version:1
 */
interface RepositoryInterface
{
    /**
     * Get all
     * @return mixed
     *  27/12/2023
     * version:1
     */
    public function getAll();

    /**
     * Get one
     * @param $id
     * @return mixed
     * 27/12/2023
     * version:1
     */
    public function find($id);

    /**
     * Create
     * @param array $attributes
     * @return mixed
     * 27/12/2023
     * version:1
     */
    public function create($attributes = []);

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     * 27/12/2023
     * version:1
     */
    public function update($id, $attributes = []);

    /**
     * Delete
     * @param $id
     * @return mixed
     * 27/12/2023
     * version:1
     */
    public function delete($id);
}
