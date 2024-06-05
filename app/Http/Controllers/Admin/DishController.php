<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dish;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\trait\UploadPhotoTrait;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreDishRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateDishRequest;

class DishController extends Controller
{
    use UploadPhotoTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $dishes = Dish::all();
            $deletedDishes = Dish::onlyTrashed()->get();
            $categories = Category::all();
            return view('Admin.dishes', compact('dishes', 'categories','deletedDishes'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }      

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDishRequest $request)
    {
        try {
            $validatedData = $request->validated();

            // $photoName = time() . '.' . $request->photo->extension();
            // $request->photo->move(public_path('images'), $photoName);
            
            $photoName = $this->storeFile( $validatedData['photo']);
            

            Dish::create([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'descraption' => $validatedData['descraption'],
                'photo' =>  $photoName,
                'cat_id' => $validatedData['cat_id'],
            ]);

            return redirect()->route('dishes.index')->with('success', 'Dish created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('dishes.index')->with('error', 'Failed to create dish: ' . $e->getMessage());
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDishRequest $request, Dish $dish)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('photo')) {
                // $photoName = time() . '.' . $request->photo->extension();
                // $request->photo->move(public_path('images'), $photoName);
                $photoName = $this->storeFile( $validatedData['photo']);
                
                if ($dish->photo && file_exists(public_path('images') . '/' . $dish->photo)) {
                    unlink(public_path('images') . '/' . $dish->photo);
                    //File::delete(public_path('images/' . $dish->photo));
                    mkdir(public_path('images/Deleted'), 0755, true);
                }

                $dish->photo = $photoName;
            }

            $dish->name = $validatedData['name'];
            $dish->price = $validatedData['price'];
            $dish->descraption = $validatedData['descraption'];
            $dish->cat_id = $validatedData['cat_id'];
            $dish->save();

            return redirect()->route('dishes.index', $dish)->with('success', 'Dish updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('dishes.index')->with('error', 'Failed to update dish: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dish $dish)
    {
        try {
            if ($dish->photo && file_exists(public_path('images') . '/' . $dish->photo)) {
                File::delete(public_path('images/' . $dish->photo));
            }

            $dish->delete();
            return redirect()->route('dishes.index')->with('success', 'Dish deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('dishes.index')->with('error', 'Failed to delete dish: ' . $e->getMessage());
        }
    }
}
