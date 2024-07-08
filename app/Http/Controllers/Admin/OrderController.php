<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dish;
use App\Models\User;
use App\Models\Order;
use App\Models\Table;

use App\Http\Controllers\Controller;
use App\Http\Services\OrderServices;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    private $OrderServices;
    public function __construct(OrderServices $OrderServices)
    {

        $this->middleware(['permission:ادارةالطلبات|الطلبات'])->only('index');
        $this->middleware(['permission:اضافة طلب'])->only('store');
        $this->middleware(['permission:تعديل طلب'])->only('update');
        $this->middleware(['permission:حذف طلب'])->only(['destroy', 'forceDelete']);
        $this->middleware(['permission:استعادة طلب'])->only('restore');
        $this->OrderServices = $OrderServices;
    }

//========================================================================================================================

    public function index()
    {
        try {
            $tables = Table::all();
            $dishes = Dish::all();
            $users = User::all();
            $orders = Order::all();
            $trashedOrders = $this->OrderServices->GetAllOrders();
            return view('Admin.order', compact('tables', 'dishes', 'users', 'trashedOrders','orders'));
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'An error occurred  ' . $e->getMessage());
        }
    }

//========================================================================================================================
    public function store(OrderRequest $request)
    {
        try {
            $this->OrderServices->StoreOrders($request->validated());
            return redirect()->route('order.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

//========================================================================================================================

public function update(UpdateOrderRequest $request , Order $order)
{
    try {
        
            $this->OrderServices->UpdateOrders($request->validated(),$order);
            return redirect()->route('order.index');

        } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
    }
}


//========================================================================================================================

    public function destroy(Order $order)
    {
        try {
            $this->OrderServices->DestroyOrders($order);
            return redirect()->route('order.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

//========================================================================================================================
    public function restore($id)
    {
        try {
            $this->OrderServices->RestoreOrders($id);
            return redirect()->route('order.index')->with('edit', 'Order restored successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Order: ' . $e->getMessage());
        }
    }

//========================================================================================================================

    public function forceDelete($id)
    {
        try {
            $this->OrderServices->ForceDeleteOrders($id);
            return redirect()->route('order.index')->with('delete', 'Order permanently deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete Order: ' . $e->getMessage());
        }
    }
    
//========================================================================================================================

}
