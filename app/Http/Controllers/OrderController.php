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
}
