<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\OrderResource;
use App\Mail\OrderApprovedMail;
use App\Mail\OrderMail;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        return OrderResource::collection(Order::all());
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function approveOrder(Order $order)
    {
        $order->update(['status' => 'Approved']);

        $customerEmail = User::find($order->user_id)->email;

        $customerFirstName = User::find($order->user_id)->first_name;

        $customerLastName = User::find($order->user_id)->last_name;

        Mail::to($customerEmail)->send(new OrderMail($order, $customerFirstName, $customerLastName));

        return response()->json(
            [
                'message' => 'Order approved successfully',
            ],
            200
        );
    }

    public function rejectOrder(Order $order)
    {
        $order->update(['status' => 'Rejected']);

        return response()->json(
            [
                'message' => 'Order rejected successfully',
            ],
            200
        );
    }

    public function store(Request $request)
    {
        $order = Order::with('user')->create([
            'user_id' => $request->user_id,
            'artboards' => json_encode($request->artboards),
            'status' => 'Pending',
            'total' => $request->total,
        ]);

        return response()->json(
            [
                'order' => $order,
                'message' => 'Order created successfully',
            ],
            200
        );
    }
}
