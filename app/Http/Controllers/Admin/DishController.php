<?php

namespace App\Http\Controllers\Admin;

use Exception;
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
    public function __construct()
    {

        $this->middleware(['permission:ادارة الاطباق|الاطباق'])->only('index');
        $this->middleware(['permission:اضافة طبق'])->only('store');
        $this->middleware(['permission:تعديل طبق'])->only('update');
        $this->middleware(['permission:حذف طبق'])->only(['destroy', 'forceDelete']);
        $this->middleware(['permission:استعادة طبق'])->only('restore');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $dishes = Dish::all();
            $deletedDishes = Dish::onlyTrashed()->get();
            $categories = Category::all();
            return view('Admin.dishes', compact('dishes', 'categories', 'deletedDishes'));
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

            $photoName = $this->storeFile($validatedData['photo']);


            Dish::create([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'descraption' => $validatedData['descraption'],
                'photo' => $photoName,
                'cat_id' => $validatedData['cat_id'],
            ]);
            // session()->flash('Add','Add succsesfuly');
            return redirect()->route('dishes.index')->with('Add', 'Dish created successfully');
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
                $photoName = $this->storeFile($validatedData['photo']);

                if ($dish->photo && file_exists(public_path('images') . '/' . $dish->photo)) {
                    unlink(public_path('images') . '/' . $dish->photo);
                    File::delete(public_path('images/' . $dish->photo));

                }

                $dish->photo = $photoName;
            }

            $dish->name = $validatedData['name'];
            $dish->price = $validatedData['price'];
            $dish->descraption = $validatedData['descraption'];
            $dish->cat_id = $validatedData['cat_id'];
            $dish->save();


            return redirect()->route('dishes.index', $dish)->with('edit', 'Dish updated successfully');
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
                // File::delete(public_path('images/' . $dish->photo));
                $targetPath = public_path('images/Deleted/' . $dish->photo);

                // Ensure the target directory exists
                if (!File::exists(public_path('images/Deleted'))) {
                    File::makeDirectory(public_path('images/Deleted'), 0755, true);
                }

                // Move the file
                File::move(public_path('images/' . $dish->photo), $targetPath);
            }

            $dish->delete();
            session()->flash('delete', 'delete succsesfuly');
            return redirect()->route('dishes.index')->with('delete', 'Dish deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('dishes.index')->with('error', 'Failed to delete dish: ' . $e->getMessage());
        }
    }

    //..........soft Delete........................
    public function restore($id)
    {

        try {
            $dish = Dish::withTrashed()->findOrFail($id);

            // Check if the dish has a photo and the file exists in the Deleted directory
            if ($dish->photo && file_exists(public_path('images/Deleted/') . $dish->photo)) {
                // Move the photo back to the original directory
                $deletedPhotoPath = public_path('images/Deleted/') . $dish->photo;
                $originalPhotoPath = public_path('images/') . $dish->photo;
                File::move($deletedPhotoPath, $originalPhotoPath);

            }

            //ٌrestore the Dish
            $dish->restore();
            return redirect()->route('dishes.index')->with('success', 'Dish restored successfully');

        } catch (\Exception $e) {
            return redirect()->route('dishes.index')->with('error', 'Dish restored successfully');
        }

    }


    public function forceDelete($id)
    {
        try {
            $dish = Dish::withTrashed()->findOrFail($id);

            // Check if the dish has a photo and the file exists in the Deleted directory
            if ($dish->photo && file_exists(public_path('images/Deleted') . '/' . $dish->photo)) {
                // Delete the photo permanently
                File::delete(public_path('images/Deleted/' . $dish->photo));
            }

            // Permanently delete the dish
            $dish->forceDelete();

            return redirect()->route('dishes.index')->with('success', 'Dish permanently deleted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('Error', 'Failed to delete Dish: ' . $e->getMessage());
        }
    }


}
