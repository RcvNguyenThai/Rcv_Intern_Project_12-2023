<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;

/**
 * BaseRepository for using with repository pattern with base methods
 * 27/12/2023
 * version:1
 */
abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    /**
     * Set the model for the class.
     *
     * @throws Some_Exception_Class description of exception
     * 27/12/2023
     * version:1
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }


    /**
     * Get all the data.
     *
     * @return Model[] 
     * 27/12/2023
     * version:1
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * A description of the find function.
     *
     * @param datatype $id description of the id parameter
     * @throws Some_Exception_Class description of the exception
     * @return Some_Return_Value
     * 27/12/2023
     * version:1
     */
    public function find($id)
    {
        $result = $this->model->find($id);

        return $result;
    }


    /**
     * Create a new record in the database.
     *
     * @param array $attributes The attributes for the new record.
     * @return mixed The created record.
     * 27/12/2023
     * version:1
     */
    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    /**
     * Updates a record in the database.
     *
     * @param int $id The ID of the record to update.
     * @param array $attributes The attributes to update.
     * 27/12/2023
     * version:1
     */
    public function update($id, $attributes = [])
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    /**
     * Deletes a record from the database.
     *
     * @param int $id The ID of the record to delete.
     * @return bool True if the record was successfully deleted, false otherwise.
     * 27/12/2023
     * version:1
     */
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
