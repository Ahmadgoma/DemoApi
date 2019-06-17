<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    use ApiResponse;
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
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
        $categories = $this->repository->paginate(10, ['id', 'name', 'created_at']);

        return $this->successResponse($categories,'categories has been returned successfully paginated with 10 records.');
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
            'name' => 'required|string|min:3|max:200'
        ]);

        if ($validator->fails()) {
            return $this->failResponse($validator->errors()->first() , 'Error in validation');
        }

        $category = $this->repository->create($request->all());

        if ($category) {
            return $this->successResponse($category,'categories has been created successfully .');
        }
        return $this->failResponse('Error in creating category.');

    }

    /**
     * Display the specified resource.
     *
     * @param  $category
     * @return \Illuminate\Http\Response
     */
    public function show($category)
    {
        $category = $this->repository->findOneOrFail($category, ['id', 'name' ,'created_at']);

        return $this->successResponse($category,'category has been returned successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $category_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $category_id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:200'
        ]);

        if ($validator->fails()) {
            return $this->failResponse($validator->errors()->first() , 'Error in validation');
        }
        $isUpdated = $this->repository->update($category_id, $request->all());

        if ($isUpdated) {
            return $this->successResponse(null,'Category has been updated Successfully');
        }
        return $this->successResponse(null,'No data has been updated of Category.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($category)
    {
        $categoryDeleted = $this->repository->delete($category);

        if($categoryDeleted){

            return $this->successResponse(null ,'category has been deleted successfully.');
        }

        return $this->failResponse( 'Error in deleting category.');

    }
}
