<?php
namespace App\Http\Traits;

use App\Models\User;
use App\Models\Order;
use App\Models\Table;
use App\Models\Reservation;

trait HomeTrait
{
    public function indexTrait()
    {
        $users = User::count();

        $tables = Table::count();
        $ava_tables =Table::where('Is_available','available')
                            ->count();
        $unava_tables =Table::where('Is_available','unavailable')
                            ->count();

        $reservation = Reservation::count();
        $done_reserv = Reservation::where('status','done')
        ->count();
        $checkedin_reserv = Reservation::where('status', 'checkedin')
        ->count();
        $checkedout_reserv = Reservation::where('status', 'checkedout')
        ->count();

        $orders = Order::count();
        $completed_order = Order::where('status', 'Completed')
        ->count(); 
        $queue_order = Order::where('status', 'In Queue')
        ->count(); 
        $received_order = Order::where('status', 'Order Received')
        ->count(); 
        return view('counters',compact('users','tables','ava_tables','unava_tables',
                                       'reservation','done_reserv','checkedin_reserv','checkedout_reserv',
                                       'orders','completed_order','queue_order','received_order'));
    }
}

?>