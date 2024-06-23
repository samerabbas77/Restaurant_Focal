<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;

class CategoryController extends Controller
{
    public function __construct()
    {

        $this->middleware(['permission:إدارةالتصنيفات|التصنيفات'])->only('index');
        $this->middleware(['permission:اضافة تصنيف'])->only('store');
        $this->middleware(['permission:تعديل تصنيف'])->only('update');
        $this->middleware(['permission:حذف تصنيف'])->only(['destroy', 'forceDelete']);
        $this->middleware(['permission:استعادة تصنيف'])->only('restore');
    }

//========================================================================================================================

    public function index()
    {
        try {
            $categories = Category::all();
            $trachedCategories = Category::onlyTrashed()->get();
            return view('Admin.category', compact('categories', 'trachedCategories'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to delete category: ' . $th->getMessage());
        }
    }

//========================================================================================================================

    public function store(StoreCategoryRequest $request)
    {

        try {
            $request->validated();
            if (Category::where('name', $request->input('name'))->exists()) {
            return redirect()->back()->withErrors(['name' => 'This Category already exists.']);
        }
            $category = new Category();
            $category->name = $request->name;
            $category->save();
            session()->flash('Add', 'Add Susseccfully');
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to delete category: ' . $th->getMessage());
        }
    }

//========================================================================================================================

    public function update(StoreCategoryRequest $request, Category $category)
    {
        try {
            $request->validated();
            $category->name = $request->name;
            $category->save();
            session()->flash('edit', 'ُEdit Susseccfully');
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to delete category: ' . $th->getMessage());
        }
    }

//========================================================================================================================

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            session()->flash('delete', 'Delete Susseccfully');
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to delete category: ' . $th->getMessage());
        }
    }

//========================================================================================================================

    public function restore($id)
    {
        try {
            $category = Category::withTrashed()->findOrFail($id);
            $category->restore();

            return redirect()->route('categories.index')->with('edit', 'Category restored successfully.');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', 'Failed to delete category: ' . $th->getMessage());
        }
    }

//========================================================================================================================

    public function forceDelete($id)
    {
        try {
            $category = Category::withTrashed()->findOrFail($id);
            $category->forceDelete();

            return redirect()->route('categories.index')->with('delete', 'Category permanently deleted.');
        } catch (\Exception $th) {
            return redirect()->back()->with('error', 'Failed to delete category: ' . $th->getMessage());
        }
    }
    
//========================================================================================================================

}
