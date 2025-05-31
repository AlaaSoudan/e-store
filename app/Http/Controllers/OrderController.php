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

public function update(Request $request, Order $order)
{
    // تحقق من صحة البيانات
    $validated = $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'order_date' => 'required|date',
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.unit_price' => 'required|numeric|min:0',
        'items.*.quantity' => 'required|integer|min:1',
    ]);

    // تحديث بيانات الطلب الأساسية
    $order->update([
        'customer_id' => $validated['customer_id'],
        'order_date' => $validated['order_date'],
    ]);

    // حفظ معرفات العناصر الموجودة (في قاعدة البيانات)
    $existingItemIds = $order->orderItems()->pluck('id')->toArray();

    // جمع المعرفات الجديدة من النموذج (إذا أضفت معرف لكل عنصر)
    // (في مثالنا الحالي لم نرسل id لكل عنصر، لذا سنتعامل بطريقة حذف كل العناصر وإعادة إنشائها)

    // الأفضل: حذف كل العناصر القديمة ثم إعادة إنشائها من جديد (طريقة سهلة وموثوقة)

    // حذف كل عناصر الطلب القديمة
    $order->orderItems()->delete();

    // إنشاء عناصر جديدة بناءً على البيانات القادمة من النموذج
    foreach ($validated['items'] as $itemData) {
        $order->orderItems()->create([
            'product_id' => $itemData['product_id'],
            'unit_price' => $itemData['unit_price'],
            'quantity' => $itemData['quantity'],
        ]);
    }

    return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
}


    public function destroy(Order $order)
    {
        $this->orderService->delete($order);
        return redirect()->route('orders.index');
    }
}
