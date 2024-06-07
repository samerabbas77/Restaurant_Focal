<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $categories = Category::all();
            $trachedCategories=Category::onlyTrashed()->get();
            return view('Admin.category',compact('categories','trachedCategories'));
        }catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to delete category: ' . $th->getMessage());
        }    
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
 
        try{
        $request->validated();
           $category=new Category();
           $category->name=$request->name;
           $category->save();
           session()->flash('Add','Add Susseccfully');
           return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to delete category: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */

  

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        try{
           $request->validated();
           $category->name=$request->name;
           $category->save();
           session()->flash('edit','ُEdit Susseccfully');
           return redirect()->route('categories.index');
        }catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to delete category: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try{
           $category->delete();
           session()->flash('delete','Delete Susseccfully');
           return redirect()->route('categories.index') ;
        }catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to delete category: ' . $th->getMessage());
        }
    }
    public function restore($id)
    {    
        try {
           $category = Category::withTrashed()->findOrFail($id);
           $category->restore();

           return redirect()->route('categories.index')->with('edit', 'Category restored successfully.');
        }
        catch (\Exception $th) {
           return redirect()->back()->with('error', 'Failed to delete category: ' . $th->getMessage());
        }
    }
    public function forceDelete($id)
    {    
        try {
           $category = Category::withTrashed()->findOrFail($id);
           $category->forceDelete();

           return redirect()->route('categories.index')->with('delete', 'Category permanently deleted.');
        }
        catch (\Exception $th) {
            return redirect()->back()->with('error', 'Failed to delete category: ' . $th->getMessage());
        }
    }
}
