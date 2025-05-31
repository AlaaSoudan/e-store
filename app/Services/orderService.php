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
            $order->update($data);
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
