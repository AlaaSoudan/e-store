@extends('layouts.app')

@section('content')
    <h2>Create Order</h2>

   <form action="{{ route('orders.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Customer</label>
        <select name="customer_id" class="form-control" required>
            <option value="">-- Select Customer --</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Order Date</label>
        <input type="date" name="order_date" class="form-control" required>
    </div>

    <hr>
    <h5>Order Items</h5>
    <table class="table" id="items-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <button type="button" class="btn btn-secondary" onclick="addRow()">+ Add Item</button>

    <div class="mt-3">
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>

<script>
    const products = @json($products);
    let rowCount = 0;

    function addRow(productId = '', unitPrice = '', quantity = '') {
        const row = `
            <tr>
                <td>
                    <select name="items[${rowCount}][product_id]" class="form-control" required onchange="updatePrice(this)">
                        <option value="">-- Select --</option>
                        ${products.map(p => `<option value="${p.id}" ${p.id == productId ? 'selected' : ''}>${p.product_name}</option>`).join('')}
                    </select>
                </td>
                <td><input type="number" name="items[${rowCount}][unit_price]" class="form-control" step="0.01" value="${unitPrice}" required></td>
                <td><input type="number" name="items[${rowCount}][quantity]" class="form-control" value="${quantity}" required></td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">X</button></td>
            </tr>
        `;
        document.querySelector('#items-table tbody').insertAdjacentHTML('beforeend', row);
        rowCount++;
    }

    function updatePrice(selectEl) {
        const selectedId = selectEl.value;
        const product = products.find(p => p.id == selectedId);
        const priceInput = selectEl.closest('tr').querySelector('input[name$="[unit_price]"]');
        if (product && priceInput) priceInput.value = product.unit_price;
    }

    window.onload = () => {
        addRow();
    };
</script>



@endsection
