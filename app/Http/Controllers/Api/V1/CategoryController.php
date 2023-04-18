<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Category;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(12);
        return CategoryResource::collection($categories);
    }

    public function all()
    {
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function store(StoreCategoryRequest $storeCategoryRequest)
    {
        $category = Category::create($storeCategoryRequest->validated());

        return response()->json($category, 200);
    }

    public function update(StoreCategoryRequest $storeCategoryRequest, Category $category)
    {
        $category->update($storeCategoryRequest->validated());

        return response()->json($category, 200);
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();

            return response()->json(
                [
                    'message' => 'Category deleted successfully',
                ],
                200
            );
        } catch (QueryException $exception) {
            if ($exception->getCode() === '23000') {
                return response()->json(
                    [
                        'message' => 'Category cannot be deleted because it is associated with an artboard.',
                    ],
                    400
                );
            }
        }
    }
}
