<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Pagination\PaginationRequest;
use App\Http\Resources\Category\ListCategoriesResource;
use App\Services\CategoryService;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->middleware(['auth:api', 'role:admin'])->only(['store', 'update', 'destroy']);
    }

    public function index(PaginationRequest $request){
        try {
            $data = $this->categoryService->getAll($request);
            return $this->respond(new ListCategoriesResource($data));
        }catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function show($id){
        try {
            $data = $this->categoryService->getById($id);
            return $this->successResponse($data, 'Category retrieved successfully');
        }catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }
    public function showBySlug($slug){
        try {
            $data = $this->categoryService->getBySlug($slug);
            return $this->successResponse($data, 'Category retrieved successfully');
        }catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function store(StoreCategoryRequest $request){
        try {
            $data = $this->categoryService->create($request);
            return $this->successResponse($data, 'Category created successfully',201);
        }catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function update(StoreCategoryRequest $request, $id){
        try {
            $data = $this->categoryService->update($id, $request);
            return $this->successResponse($data, 'Category updated successfully');
        }catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function destroy($id){
        try {
            $this->categoryService->delete($id);
            return $this->successResponse('', 'Category deleted successfully');
        }catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }
}
