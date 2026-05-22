<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::withCount('items')->orderBy('created_at', 'desc');

        if ($request->has('q') && $request->q !== '') {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('order_code', 'like', "%{$searchTerm}%")
                  ->orWhere('customer_phone', 'like', "%{$searchTerm}%")
                  ->orWhere('customer_name', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('order_status', $request->status);
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_status' => 'required|in:pending,processing,shipping,completed,cancelled'
        ]);

        if ($validated['order_status'] === 'cancelled' && $order->order_status !== 'cancelled') {
            $order->load('items');
            foreach ($order->items as $item) {
                if (!empty($item->sku)) {
                    $variant = \App\Models\ProductVariant::where('sku', $item->sku)->first();
                    if ($variant) {
                        $variant->increment('stock', $item->quantity);
                    }
                }
            }
        } elseif ($order->order_status === 'cancelled' && $validated['order_status'] !== 'cancelled') {
            $order->load('items');
            foreach ($order->items as $item) {
                if (!empty($item->sku)) {
                    $variant = \App\Models\ProductVariant::where('sku', $item->sku)->first();
                    if ($variant) {
                        $variant->decrement('stock', $item->quantity);
                    }
                }
            }
        }

        $order->update(['order_status' => $validated['order_status']]);

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công.');
    }

    public function destroy(Order $order)
    {
        if ($order->order_status !== 'cancelled') {
            $order->load('items');
            foreach ($order->items as $item) {
                if (!empty($item->sku)) {
                    $variant = \App\Models\ProductVariant::where('sku', $item->sku)->first();
                    if ($variant) {
                        $variant->increment('stock', $item->quantity);
                    }
                }
            }
        }
        
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Đã xóa đơn hàng thành công.');
    }
}
