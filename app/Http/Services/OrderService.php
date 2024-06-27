<?php

namespace App\Http\Services;

use App\Models\Dish;
use App\Models\Order;
use App\Models\Reservation;
use App\Http\Resources\DetailsOrderResource;
use App\Http\Resources\UpdateOrderResource;
use App\Http\Requests\ApiRequests\ApiUpdateOrderRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use App\Http\Traits\ApiTraits\ApiTrait;
use App\Http\Traits\ApiTraits\ApiResponse;
use App\Http\Requests\ApiRequests\ApiOrderRequest;

class OrderService
{
    use ApiResponse, ApiTrait;

    private function getUserId()
    {
        return Auth::id();
    }

    public function getAllOrders()
    {
        try {
            $userId = $this->getUserId();
            $orders = Order::where('user_id',$userId)->get();
            $allOrder = OrderResource::collection($orders);
            return $this->Response($allOrder, "All orders fetched successfully", 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->customeResponse('Something went wrong with fetching orders', 400);
        }
    }

    public function createOrder(array $data)
    {
        try {
            $userId = $this->getUserId();
            $checkReservation = Reservation::where('user_id', $userId)
                                           ->where('status', 'checkedin')
                                           ->exists();

            if ($checkReservation) {
                $order = $this->createNewOrder($data, $userId);
                return $this->Response(new OrderResource($order), "Order created successfully", 201);
            } else {
                return $this->customeResponse("Your status reservation is Checkout. You have to Checkin to make an order", 201);
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->customeResponse('Something went wrong with adding order', 400);
        }
    }

    private function createNewOrder(array $data)
    {
        $userId = $this->getUserId();
        $dishes = $data['dishes'];
        $order = new Order();
        $order->user_id = $userId;
        $order->table_id = $data['table_id'];
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

        return $order;
    }

    public function orderInfo($id)
    {
        try {
            $userId = $this->getUserId();
            $order = Order::with('dishes')->where('user_id',$userId)->findOrFail($id);
            return $this->Response(new DetailsOrderResource($order), "Order details fetched successfully", 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->customeResponse('Something went wrong with fetching order details', 400);
        }
    }

    public function updateOrder(array $data, $id)
    {
        try {
            $userId = $this->getUserId();
            $order = Order::where('id', $id)->where('user_id', $userId)->where('status', 'In Queue')->firstOrFail();
            $this->updateOrderDetails($order, $data);
            return $this->Response(new UpdateOrderResource($order), "Order updated successfully", 201);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->customeResponse('Something went wrong with updating the order', 400);
        }
    }

    private function updateOrderDetails(Order $order, array $data)
    {
        $userId = $this->getUserId();
        $dishes = $data['dishes'];

        $order->table_id = $data['table_id'];
        $order->user_id=$userId;
        $totalPrice = 0;
        $syncData = [];

        foreach ($dishes as $dishData) {
            $dish = Dish::findOrFail($dishData['id']);
            $quantity = $dishData['quantity'];
            $syncData[$dish->id] = ['quantity' => $quantity];
            $totalPrice += $dish->price * $quantity;
        }

        $order->total_price = $totalPrice;
        $order->save();
        $order->dishes()->sync($syncData);
    }

    public function deleteOrder($id)
    {
        try {
            $userId = $this->getUserId();
            $order = Order::where('id', $id)->where('user_id',$userId)->where('status', 'In Queue')->firstOrFail();
            $order->dishes()->detach();
            $order->forceDelete();

            return $this->Response(null, "Order deleted successfully", 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return $this->customeResponse('Something went wrong with deleting orders', 400);
        }
    }
}
