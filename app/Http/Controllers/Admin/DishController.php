<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Dish;
use App\Http\Traits\DishTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Traits\UploadPhotoTrait;
use App\Http\Requests\StoreDishRequest;
use App\Http\Requests\UpdateDishRequest;

class DishController extends Controller
{

    use UploadPhotoTrait,DishTrait;
    public function __construct()
    {
        $this->middleware(['permission:ادارة الاطباق|الاطباق'])->only('index');
        $this->middleware(['permission:اضافة طبق'])->only('store');
        $this->middleware(['permission:تعديل طبق'])->only('update');
        $this->middleware(['permission:حذف طبق'])->only(['destroy', 'forceDelete']);
        $this->middleware(['permission:استعادة طبق'])->only('restore');
    }

//Index========================================================================================================================

    public function index()
    {
        try {
            return $this->indexTrait();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }

    }

//Store========================================================================================================================

    public function store(StoreDishRequest $request)
    {
        try {
           return $this->storeTrait($request);
        } catch (\Exception $e) {
            return redirect()->route('dishes.index')->with('error', 'Failed to create dish: ' . $e->getMessage());
        }
    }

//Update========================================================================================================================

    public function update(UpdateDishRequest $request, Dish $dish)
    {
        try {
            return $this->updateTrait($request,$dish);
        } catch (\Exception $e) {
            return redirect()->route('dishes.index')->with('error', 'Failed to update dish: ' . $e->getMessage());
        }
    }

//Delete========================================================================================================================

    public function destroy(Dish $dish)
    {
        try {
            return $this->deleteTrait($dish);
        } catch (\Exception $e) {
            return redirect()->route('dishes.index')->with('error', 'Failed to delete dish: ' . $e->getMessage());
        }
    }

//Soft Delete========================================================================================================================
    public function restore($id)
    {
        try {
            return $this->softDeleteTrait($id);
        } catch (\Exception $e) {
            return redirect()->route('dishes.index')->with('error', 'Failed to restored Dish'  );
        }

    }

//Force Delete========================================================================================================================

    public function forceDelete($id)
    {
        try {
            return $this->forceDeleteTrait($id);
        } catch (\Exception $e) {
            return redirect()->back()->with('Error', 'Failed to delete Dish: ' . $e->getMessage());
        }
    }

//========================================================================================================================

}
