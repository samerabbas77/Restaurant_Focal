<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Dish;
use App\Http\Traits\ApiTraits;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\DishResource;
use App\Http\Traits\ApiTraits\ApiTrait;

class DishController extends Controller
{
    use ApiTrait;
    public function all_dishes()
    {
        try {

        $dishes = DishResource::collection(Dish::with('category')->get()); 
        return $this->Response($dishes,"all available dishes successfully",200);

        }catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->customeResponse('something wrong with All Dishes', 400);
        }

    }
}
