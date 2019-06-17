<?php

namespace App\Repositories;

use App\Article;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\ArticleRepositoryInterface;

class ArticleRepository implements ArticleRepositoryInterface
{
    use BaseRepository;

    /**
     * The validation instance.
     *
     * @var \App\Article
     */
    protected $model;

    /**
     * EmployeeRepository constructor.
     * @param Article $model
     */
    public function __construct(Article $model) {
        $this->model = $model;
    }


    /**
     * @param int $perPage
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function paginateWithJoin (int $perPage = 10,
        array $columns = ['*'],
        string $orderBy = 'articles.id',
        string $sortBy = 'desc'
    )
    {
        return $this->model->select($columns)
            ->join('categories', function ($join){
                $join->on(
                    'categories.id',
                    '=',
                    'articles.category_id'
                );
            })
            ->orderBy($orderBy, $sortBy)->paginate($perPage);
    }


    /**
     * @param int $id
     * @param array $columns
     * @return mixed
     */
    public function findWithJoin(int $id , array  $columns )
    {
        return $this->model->select($columns)
            ->join('categories', function ($join){
                $join->on(
                    'categories.id',
                    '=',
                    'articles.category_id'
                );
            })
            ->find($id);
    }

}