<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            return view('Admin.category',compact('categories'));
        }catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'An error occurred');
        }    
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('Admin.category');
    // }

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
           return redirect()->route('categories.store');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'An error occurred');
        }
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Category $category)
    // {
    //     return view('Admin.category',compact('category'));
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        @dd($request);
        try{
           $request->validated();
           $category->name=$request->name;
           $category->save();
           session()->flash('edit','ُEdit Susseccfully');
           return redirect()->route('categories.update');
        }catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'An error occurred');
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
           return redirect()->route('categories.destroy') ;
        }catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'An error occurred');
        }
    }
}
