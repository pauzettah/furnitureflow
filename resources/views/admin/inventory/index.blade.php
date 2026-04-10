@extends('admin.dashboard')

@section('title', 'Inventory Management')

@section('content')
<div class="fade-up">
    <div class="section-header">
        <div>
            <div class="section-title">Inventory Management</div>
            <div class="section-sub">View and manage all products</div>
        </div>
        <a href="#" class="section-action"><i class="fa-solid fa-plus"></i> Add Product</a>
    </div>

    <div class="data-table-wrap">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Production Days</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category }}</td>
                        <td>KES {{ number_format($product->base_price) }}</td>
                        <td>{{ $product->production_days }} days</td>
                        <td>
                            @if($product->is_active)
                                <span class="badge badge-ready">Active</span>
                            @else
                                <span class="badge badge-pending">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.inventory.show', $product->id) }}" class="btn-view">View</a>
                                <button class="btn-edit">Edit</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No products found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection