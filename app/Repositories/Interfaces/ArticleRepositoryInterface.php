<?php

namespace App\Repositories\Interfaces;

interface ArticleRepositoryInterface
{
    /**
     * @param int $perPage
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function paginateWithJoin (int $perPage = 10, array $columns = ['*'], string $orderBy = 'id', string $sortBy = 'desc');

    /**
     * @param int $id
     * @param array $columns
     * @return mixed
     */
    public  function findWithJoin(int $id , array  $columns );
}

