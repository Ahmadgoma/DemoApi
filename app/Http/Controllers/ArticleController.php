<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    use ApiResponse;

    protected $repository;

    public function __construct(ArticleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = $this->repository->paginateWithJoin(10, ['articles.id', 'articles.title' ,'articles.body', 'categories.name','articles.created_at']);

        return $this->successResponse($articles,'categories has been returned successfully paginated with 10 records.');

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3|max:200',
            'body' => 'required|min:3|max:2000',
            'category_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->failResponse($validator->errors()->first() , 'Error in validation');
        }

        $article = $this->repository->create($request->all());

        if ($article) {
            return $this->successResponse($article,'Article has been created successfully .');
        }
        return $this->failResponse('Error in creating article.');

    }

    /**
     * Display the specified resource.
     *
     * @param  $article
     * @return \Illuminate\Http\Response
     */
    public function show($article)
    {
        $article = $this->repository->findWithJoin($article, ['articles.id', 'articles.title' ,'articles.body', 'categories.name','articles.created_at']);

        return $this->successResponse($article,'article has been returned successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $article_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $article_id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3|max:200',
            'body' => 'required|min:3|max:2000',
            'category_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->failResponse($validator->errors()->first() , 'Error in validation');
        }
        $isUpdated = $this->repository->update($article_id, $request->all());

        if ($isUpdated) {
            return $this->successResponse(null,'Article has been updated Successfully');
        }
        return $this->successResponse(null,'No data has been updated of Article.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy( $article)
    {
        $articleDeleted = $this->repository->delete($article);

        if($articleDeleted){

            return $this->successResponse(null ,'article has been deleted successfully.');
        }

        return $this->failResponse( 'Error in deleting article.');
    }
}
