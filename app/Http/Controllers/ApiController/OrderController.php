<?php

namespace App\Http\Controllers\ApiController;
use App\Http\Traits\ApiTraits\ApiTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiRequests\ApiOrderRequest;
use App\Http\Requests\ApiRequests\ApiUpdateOrderRequest;
use App\Http\Services\OrderService;

class OrderController extends Controller
{
    use ApiTrait;
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService=$orderService;
    }
    public function all_order()
    {
       return $this->orderService->getAllOrders();
    }

//========================================================================================================================

    public function add_order(ApiOrderRequest $request)
    {
        $order = $request->validated();
        return $this->orderService->createOrder($order);
    }

//========================================================================================================================

public function details_order($id)
{
   return $this->orderService->orderInfo($id);
}

//========================================================================================================================

public function update_order(ApiUpdateOrderRequest $request, $id)
{
   $order = $request->validated();
   return $this->orderService->updateOrder($order,$id);
}


//========================================================================================================================

public function delete_order($id)
{
    return $this->orderService->deleteOrder($id);
}

}

