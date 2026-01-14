<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Category\CategoryService;
use App\Services\Category\CategoryListService;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CategoryListService $service)
    {
        $categories = $service->execute($request);
        if ($request->ajax()) {
            return response()->json([
                'rows' => view('admin.categories._rows', compact('categories'))->render(),
                'pagination' => $categories->links('pagination::bootstrap-5')->render(),
            ]);
        }
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreCategoryRequest $request, CategoryService $service)
    {
        $service->create($request->validated());
        return redirect()
            ->route('categories.index')
            ->with('success', __('Category submitted successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return response()->json($category);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category, CategoryService $service)
    {
        $service->update($category, $request->validated());


        return redirect()
            ->route('categories.index')
            ->with('success', __('Category updated successfully.'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->deleteImages(); // حذف كل الصور
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', __('Category deleted successfully.'));
    }
}
