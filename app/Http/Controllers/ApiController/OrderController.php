<?php

namespace App\Http\Controllers\ApiController;


use App\Models\Dish;
use App\Models\Order;
use App\Models\Reservation;

use App\Http\trait\ApiTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Resources\OrderResource;
use App\Http\Resources\UpdateOrderResource;
use App\Http\Resources\DetailsOrderResource;

use App\Http\Requests\ApiRequests\ApiOrderRequest;
use App\Http\Requests\ApiRequests\ApiUpdateOrderRequest;


class OrderController extends Controller
{
    use ApiTrait;
    public function all_order()
    {
        try {
    
            $orders = Order::where('user_id', Auth::user()->id)->get();
    
            $all_order = OrderResource::collection($orders);
    
            return $this->Response($all_order, "all orders fetched successfully", 200);
    
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->customeResponse('something went wrong with fetching orders', 400);
        }
    }

//========================================================================================================================

    public function add_order(ApiOrderRequest $request)
    {
        try {

            $check_reservation = Reservation::where('user_id',Auth::user()->id)
                                             ->where('status','Chackin')
                                             ->exists();
            
            if($check_reservation){ 
                
                $dishes = $request->input('dishes');

                $order = new Order();
                $order->user_id = Auth::user()->id;
                $order->table_id = $request->table_id;
                $order->total_price = 0;
                $order->status = 'In Queue';
                $order->save();
    
                $totalPrice = 0;
    
                foreach ($dishes as $dishData) {
                    $dish = Dish::findOrFail($dishData['id']);
                    $quantity = $dishData['quantity'];
                    $order->dishes()->attach($dish->id, ['quantity' => $quantity]);
                    $totalPrice += $dish->price * $quantity;
                }
    
                $order->total_price = $totalPrice;
                $order->save();
        
                return $this->Response(new OrderResource($order),"order created successfully",201);
            }else{
                return $this->customeResponse("your status reservation is Checkout , you have to Checkin to make order",201);
            }                               

        }catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->customeResponse('something wrong with add order', 400);
        }

    }

//========================================================================================================================

public function details_order($id)
{
    try {
        $order = Order::with('dishes')
                      ->where('id', $id)
                      ->where('user_id', Auth::user()->id)
                      ->first();

        return $this->Response( new DetailsOrderResource ($order), "Order details fetched successfully", 200);

    } catch (\Throwable $th) {
        Log::error($th->getMessage());
        return $this->customeResponse('Something went wrong with fetching order details', 400);
    }
}

//========================================================================================================================

public function update_order(ApiUpdateOrderRequest $request, $id)
{
    try {

        $check_order = Order::where('user_id',Auth::user()->id)
                                             ->where('status','In Queue')
                                             ->exists();
            
        if($check_order){

            $dishes = $request->input('dishes');

            $order = order::findOrFail($id);

            $order->table_id = $request->table_id;

            $totalPrice = 0;
            $existingDishes = [];
            foreach ($dishes as $dishData) {
                $dish = Dish::findOrFail($dishData['id']);
                $quantity = $dishData['quantity'];

                if ($order->dishes->contains($dish->id)) {
                    $order->dishes()->updateExistingPivot($dish->id, ['quantity' => $quantity]);
                } else {
                    $order->dishes()->attach($dish->id, ['quantity' => $quantity]);
                }

                $totalPrice += $dish->price * $quantity;
                $existingDishes[$dish->id] = ['quantity' => $quantity];
            }

            $order->dishes()->sync($existingDishes);

            $order->total_price = $totalPrice;
            $order->save();
            $order->dishes()->syncWithoutDetaching($existingDishes);

            return $this->Response(new UpdateOrderResource($order),"order update successfully",201);
        }else{
            return $this->customeResponse("your status order is 'Order Received' or 'Completed' ,you cant not update this order",201);
        } 

    } catch (\Throwable $th) {
        Log::error($th->getMessage());
        return $this->customeResponse('Something went wrong with updating order ', 400);
    }
}

//========================================================================================================================

public function delete_order($id)
{
    try {
        $check_order = Order::where('user_id',Auth::user()->id)
                                             ->where('status','In Queue')
                                             ->exists();
            
        if($check_order){
            $order = order::findOrFail($id);
            $order->dishes()->detach();
            $order->delete();
            //هون لأن عنا سوفت ديليت فمشان اذا الزبون حذف طلبو ينحذ كليا
            $order = Order::withTrashed()->findOrFail($id);
            $order->forceDelete();

            return $this->Response(null, "order delete successfully", 200);
        }else{
            return $this->customeResponse("your status order is 'Order Received' or 'Completed' , you cant not delete this order",201);
        } 

    } catch (\Throwable $th) {
        Log::error($th->getMessage());
        return $this->customeResponse('something went wrong with deleting orders', 400);
    }
}

}

