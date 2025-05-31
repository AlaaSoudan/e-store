<?php


namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Services\OrderService;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService) {}

    public function index()
    {
        $orders = Order::with('customer')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();

        return view('orders.create', compact('customers','products'));
    }

  public function store(OrderRequest $request)
{
    $this->orderService->create($request->validated());
    return redirect()->route('orders.index');
}
    public function edit(Order $order)
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('orders.edit', compact('order', 'customers','products'));
    }

public function update(OrderRequest $request, Order $order)
{


       $orderService->update($order, $validated);

    return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
}


    public function destroy(Order $order)
    {
        $this->orderService->delete($order);
        return redirect()->route('orders.index');
    }
}
