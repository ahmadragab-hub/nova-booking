<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{

    public function __construct(private CategoryService $categoryService){}

    public function index()
    {
        $categories = $this->categoryService->getCategories(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->createCategory($request->validated());
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category): View
    {
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->categoryService->updateCategory($category, $request->validated());
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->categoryService->delete($category);
        
        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted successfully.'); 
    }
}
