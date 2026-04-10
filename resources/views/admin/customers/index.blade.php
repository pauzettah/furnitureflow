@extends('admin.dashboard')

@section('title', 'Customers Management')

@section('content')
<div class="fade-up">
    <div class="section-header">
        <div>
            <div class="section-title">Customers Management</div>
            <div class="section-sub">View and manage all registered customers</div>
        </div>
        <a href="#" class="section-action"><i class="fa-solid fa-plus"></i> Add Customer</a>
    </div>

    <div class="data-table-wrap">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Orders</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td>#{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone ?? 'N/A' }}</td>
                        <td>{{ Str::limit($customer->address ?? 'N/A', 30) }}</td>
                        <td>{{ $customer->orders->count() }}</td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn-view">View</a>
                                <button class="btn-edit">Edit</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No customers found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding: 16px 24px; border-top: 1px solid #f1f5f9;">
            {{ $customers->links() }}
        </div>
    </div>
</div>
@endsection