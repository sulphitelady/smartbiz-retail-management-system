@extends('layouts.app')

@section('content')

<style>
    .page-title {
        font-size: 24px;
        font-weight: 600;
        color: #6366f1;
        margin-bottom: 20px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }

    .card {
        background: #111827;
        padding: 15px;
        border-radius: 12px;
        color: white;
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    .card h3 {
        font-size: 22px;
        margin: 0;
        color: #fff;
    }

    .card p {
        font-size: 13px;
        color: #9ca3af;
    }

    /* Table */
    .table-container {
        background: #0f172a;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        color: #e2e8f0;
    }

    th {
        background: #111827;
        text-align: left;
        padding: 14px;
        font-size: 12px;
        text-transform: uppercase;
        color: #a5b4fc;
    }

    td {
        padding: 14px;
        border-bottom: 1px solid #1f2937;
    }

    tr:hover {
        background: #1e293b;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: bold;
    }

    .low { background: rgba(245,158,11,0.2); color: #fbbf24; }
    .out { background: rgba(239,68,68,0.2); color: #f87171; }
    .good { background: rgba(16,185,129,0.2); color: #34d399; }
</style>

<h2 class="page-title">📦 Inventory Dashboard</h2>

{{-- STATS --}}
<div class="stats-grid">

    <div class="card">
        <h3>{{ $totalProducts }}</h3>
        <p>Total Products</p>
    </div>

    <div class="card">
        <h3>{{ $lowStock }}</h3>
        <p>Low Stock Items</p>
    </div>

    <div class="card">
        <h3>{{ $outStock }}</h3>
        <p>Out of Stock</p>
    </div>

</div>

{{-- TABLE --}}
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>SKU</th>
                <th>Stock</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($products as $product)

                @php
                    if($product->quantity == 0){
                        $status = "Out";
                        $class = "out";
                    } elseif($product->quantity <= 10){
                        $status = "Low";
                        $class = "low";
                    } else {
                        $status = "Good";
                        $class = "good";
                    }
                @endphp

                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>
                        <span class="badge {{ $class }}">
                            {{ $status }}
                        </span>
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>
</div>

@endsection