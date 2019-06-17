<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait BaseRepository
{
    /** Get all records from the database.
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function all(array $columns = ['*'], string $orderBy = 'id', string $sortBy = 'asc')
    {
        return $this->model->select($columns)->orderBy($orderBy, $sortBy)->get();

    }

    /**
     * Get paginated records from the database.
     *
     * @param int $perPage
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return mixed
     */
    public function paginate(
        int $perPage = 10,
        array $columns = ['*'],
        string $orderBy = 'id',
        string $sortBy = 'desc'
    ) {
        return $this->model->select($columns)->orderBy($orderBy, $sortBy)->paginate($perPage);
    }

    /**
     * Find all matching records by the given data.
     *
     * @param array $data
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return mixed
     */
    public function findBy(
        array $data,
        int $perPage,
        array $columns = ['*'],
        string $orderBy = 'id',
        string $sortBy = 'desc'
    ) {
        return $this->model->select($columns)->where($data)->orderBy($orderBy, $sortBy)->paginate($perPage);
    }

    /**
     * Find and paginated all matching records by the given data.
     *
     * @param array $data
     * @param int $perPage
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateBy(
        array $data,
        int $perPage = 15,
        array $columns = ['*'],
        string $orderBy = 'id',
        string $sortBy = 'desc'
    ): LengthAwarePaginator {
        return $this->model->select($columns)->where($data)->orderBy($orderBy, $sortBy)->paginate($perPage);
    }

    /**
     * Find a record for the given id.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function find(int $id, array $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    /**
     * Find a record by the given data.
     *
     * @param array $data
     *
     * @return array
     */
    public function findOneBy(array $data, array $columns = ['*']): array
    {
        $result = $this->model->select($columns)->where($data)->first();

        return $this->toArray($result);
    }

    /**
     * Find a record for the given id or throw a not found exception.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOneOrFail(int $id, array $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * Find a record by the given data or throw a not found exception.
     *
     * @param array $data
     *
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOneByOrFail(array $data, array $columns = ['*']): array
    {
        $result = $this->model->select($columns)->where($data)->firstOrFail();

        return $this->toArray($result);
    }

    /**
     * Create a new record.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Create multi-record.
     *
     * @param array $data
     *
     * @return bool
     */
    public function insert(array $data): bool
    {
        return $this->model->insert($data);
    }

    /**
     * Update the given model.
     *
     * @param int      $id
     * @param array    $attributes
     * @param boolean  $checkIsClean
     *
     * @return boolean
     */
    public function update(int $id, array $data, bool $checkIsClean = true): bool
    {
        $model = $this->model->findOrFail($id);

        $model = $model->fill($data);

        // You can delete this condition if you want, but I use it to be sure there's an "actual"
        // update happened.
        if ($model->isClean() && $checkIsClean) {
            return false;
        }

        return ($model->save()) ? true : false;
    }

    /**
     * Delete the given model.
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        $model = $this->model->findOrFail($id);

        return ($model->delete()) ? true : false;
    }

    /**
     * Convert the given object to array.
     *
     * @param \Illuminate\Database\Eloquent\Model $result
     *
     * @return array
     */
    public function toArray($result): array
    {
        return (is_null($result)) ? [] : $result->toArray();
    }
}
