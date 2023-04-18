<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\OrderResource;
use App\Mail\OrderApprovedMail;
use App\Models\Customer;
use App\Models\Order;
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

    public function approveOrder(Request $request, Order $order)
    {
        $order->update(['status' => 'Approved']);

        return response()->json(
            [
                'message' => 'Order approved successfully',
            ],
            200
        );
    }

    public function rejectOrder(Request $request, Order $order)
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
        $order = Order::with(['customer', 'artboard'])->create([
            'customer_id' => $request->customer_id,
            'artboard_id' => $request->artboard_id,
            'status' => 'Pending',
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
