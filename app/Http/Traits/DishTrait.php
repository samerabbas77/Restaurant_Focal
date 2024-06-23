<?php
namespace App\Http\Traits;

use App\Models\Dish;
use App\Models\Category;
use App\Http\Requests\StoreDishRequest;
use App\Http\Requests\UpdateDishRequest;
use Illuminate\Support\Facades\File;


trait DishTrait
{
//index.................................................
    public function indexTrait()
{
    $dishes = Dish::all();
    $deletedDishes = Dish::onlyTrashed()->get();
    $categories = Category::all();
    return view('Admin.dishes', compact('dishes', 'categories', 'deletedDishes'));
}

//store...........................................................
public function storeTrait(StoreDishRequest $request)
{
    $validatedData = $request->validated();

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
}
//update.......................................................................
public function updateTrait(UpdateDishRequest $request, Dish $dish)
{
    $validatedData = $request->validated();

    if ($request->hasFile('photo')) {
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
}
//Delete........................................................................
public function deleteTrait(Dish $dish)
{
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
}
//Soft Delete......................................................................
public function softDeleteTrait($id)
{
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
}
//Force Delete ..........................................................................
public function forceDeleteTrait($id)
{
    $dish = Dish::withTrashed()->findOrFail($id);

    // Check if the dish has a photo and the file exists in the Deleted directory
    if ($dish->photo && file_exists(public_path('images/Deleted') . '/' . $dish->photo)) {
        // Delete the photo permanently
        File::delete(public_path('images/Deleted/' . $dish->photo));
    }

    // Permanently delete the dish
    $dish->forceDelete();

    return redirect()->route('dishes.index')->with('success', 'Dish permanently deleted successfully.');
}

}
?>