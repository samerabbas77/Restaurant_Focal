<?php

namespace App\Http\Controllers\ApiController;


use App\Models\Dish;
use App\Models\Order;
use App\Models\Reservation;
use App\Http\trait\ApiTrait;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use App\Http\Resources\DetailsOrderResource;
use App\Http\Requests\ApiRequests\ApiOrderRequest;


class OrderController extends Controller
{
    use ApiTrait;
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
public function details_order($id)
{
    try {
        $order = Order::with('dishes')
                      ->where('id', $id)
                      ->where('user_id', Auth::user()->id)
                      ->first();

        $orderResource = new DetailsOrderResource ($order);

        return $this->Response($orderResource, "Order details fetched successfully", 200);

    } catch (\Throwable $th) {
        Log::error($th->getMessage());
        return $this->customeResponse('Something went wrong with fetching order details', 400);
    }
}


}

