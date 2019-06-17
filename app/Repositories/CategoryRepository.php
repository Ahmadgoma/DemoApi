<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Category;
use App\Repositories\BaseRepository;

class CategoryRepository implements CategoryRepositoryInterface
{
    use BaseRepository;

    /**
     * The validation instance.
     *
     * @var \App\Category
     */
    protected $model;

    /**
     * CompanyRepository constructor.
     * @param Category $model
     */
    public function __construct(Category $model) {
        $this->model = $model;
    }

}
