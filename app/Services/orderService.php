<?php
namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService
{
public function create(array $data): Order
{
    return DB::transaction(function () use ($data) {
        $items = $data['items'];
        $data['order_number'] = Order::max('order_number') + 1;
        unset($data['items']);

        $order = Order::create($data);

        foreach ($items as $item) {
            $order->items()->create([
                'product_id' => $item['product_id'],
                'unit_price' => $item['unit_price'],
                'quantity' => $item['quantity'],
            ]);
        }
        $totalAmount = $order->items->sum(function ($item) {
            return $item->unit_price * $item->quantity;
        });

        $order->update(['total_amount' => $totalAmount]);

        return $order;
    });
}

public function update(Order $order, array $data): Order
{
    return DB::transaction(function () use ($order, $data) {

        $order->update([
            'customer_id' => $data['customer_id'],
            'order_date' => $data['order_date'],
        ]);

        $order->orderItems()->delete();

        $total = 0;


        foreach ($data['items'] as $itemData) {
            $subtotal = $itemData['unit_price'] * $itemData['quantity'];
            $total += $subtotal;

            $order->orderItems()->create([
                'product_id' => $itemData['product_id'],
                'unit_price' => $itemData['unit_price'],
                'quantity' => $itemData['quantity'],
            ]);
        }

        $order->update([
            'total_amount' => $total,
        ]);

        return $order;
    });
}


    public function delete(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $order->delete();
        });
    }
}
