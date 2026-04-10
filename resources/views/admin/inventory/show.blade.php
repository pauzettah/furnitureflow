@extends('admin.dashboard')

@section('title', 'Product Details')

@section('content')
<div class="fade-up">
    <div class="section-header">
        <div>
            <div class="section-title">Product Details</div>
            <div class="section-sub">{{ $product->name }}</div>
        </div>
        <a href="{{ route('admin.inventory') }}" class="section-action"><i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>

    <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="data-table-wrap">
            <div class="data-table-header" style="padding: 20px 24px 0;">
                <div class="section-title" style="font-size: 1rem;">Product Information</div>
            </div>
            <div style="padding: 20px 24px;">
                <p><strong>SKU:</strong> {{ $product->sku }}</p>
                <p><strong>Name:</strong> {{ $product->name }}</p>
                <p><strong>Category:</strong> {{ $product->category }}</p>
                <p><strong>Base Price:</strong> KES {{ number_format($product->base_price) }}</p>
                <p><strong>Production Days:</strong> {{ $product->production_days }} days</p>
                <p><strong>Status:</strong> 
                    @if($product->is_active)
                        <span class="badge badge-ready">Active</span>
                    @else
                        <span class="badge badge-pending">Inactive</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="data-table-wrap">
            <div class="data-table-header" style="padding: 20px 24px 0;">
                <div class="section-title" style="font-size: 1rem;">Specifications</div>
            </div>
            <div style="padding: 20px 24px;">
                <p><strong>Description:</strong></p>
                <p>{{ $product->description ?? 'No description' }}</p>
                
                @if($product->dimensions)
                    <p style="margin-top: 12px;"><strong>Dimensions:</strong></p>
                    <p>
                        @php
                            // Handle both string JSON and array
                            $dims = is_string($product->dimensions) ? json_decode($product->dimensions, true) : $product->dimensions;
                        @endphp
                        @if($dims && is_array($dims))
                            {{ $dims['length'] ?? '' }} x {{ $dims['width'] ?? '' }} x {{ $dims['height'] ?? '' }} {{ $dims['unit'] ?? 'cm' }}
                        @else
                            {{ json_encode($product->dimensions) }}
                        @endif
                    </p>
                @endif
                
                @if($product->materials)
                    <p style="margin-top: 12px;"><strong>Materials:</strong></p>
                    <p>
                        @php
                            $materials = is_string($product->materials) ? json_decode($product->materials, true) : $product->materials;
                        @endphp
                        @if($materials && is_array($materials))
                            {{ implode(', ', $materials) }}
                        @else
                            {{ $product->materials }}
                        @endif
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection