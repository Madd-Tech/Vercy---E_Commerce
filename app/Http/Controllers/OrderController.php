<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request) 
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = \App\Models\Product::with('categories')->findOrFail($request->product_id);
        
        // Calculate total price
        $totalPrice = $product->price * $request->quantity;

        // Create Order
        // Initially create with temp order number or empty, then update?
        // Or generate first.
        
        // Format: today date(day & month), first letter of categories, 2 last year number, id record
        // ID record is not known yet. 
        // Strategy: Create order with temporary string, then update.
           
        $order = \App\Models\Order::create([
            'user_id' => null, // Customer order
            'customer_id' => $request->customer_id,
            'order_number' => 'TEMP-' . uniqid(),
            'status' => 'pending',
            'total_price' => $totalPrice,
        ]);

        // Generate Invoice Number
        $date = date('dm'); // DayMonth e.g. 1202
        $year = date('y'); // 26
        
        $categoryName = 'General';
        if ($product->categories && $product->categories->count() > 0) {
            $categoryName = $product->categories->first()->name;
        }
        $categoryLetter = strtoupper(substr($categoryName, 0, 1));
        
        $orderId = $order->id;
        
        $invoiceNumber = $date . $categoryLetter . $year . $orderId;
        
        $order->update(['order_number' => $invoiceNumber]);
        
        // Create Order Item
        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'qty' => $request->quantity,
            'price' => $product->price,
        ]);

        return response()->json([
            'message' => 'Order created successfully!',
            'order' => $order,
            'invoice_number' => $invoiceNumber
        ]);
    }


    public function show($order_number)
    {
        return view('users.invoice', ['orderNumber' => $order_number]);
    }

    public function getOrderByNumber($order_number)
    {
        $order = \App\Models\Order::with(['items.product', 'customer'])->where('order_number', $order_number)->firstOrFail();
        return response()->json($order);
    }

    public function cancel($id)
    {
        $order = \App\Models\Order::findOrFail($id);
        
        if ($order->status === 'pending') {
            $order->status = 'canceled';
            $order->save();
            return response()->json(['message' => 'Order canceled successfully', 'order' => $order->fresh()]);
        }

        return response()->json(['message' => 'Order cannot be canceled'], 400);
    }

    public function pay(Request $request, $id)
    {
        $order = \App\Models\Order::findOrFail($id);

        if ($order->status === 'pending') {
            // In a real scenario, you'd verify payment gateway response here.
            // For now, we simulate successful payment.
            
            $order->status = 'paid';
            $order->save();
            
            return response()->json(['message' => 'Payment successful', 'order' => $order->fresh()]);
        }

        return response()->json(['message' => 'Order cannot be paid'], 400);
    }
}
