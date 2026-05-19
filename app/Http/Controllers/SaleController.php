<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Customer;
use App\Models\InventoryLog;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer')->latest()->paginate(15);

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('quantity', '>', 0)->get();

        return view('sales.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'items' => 'required|array',
        ]);

        DB::beginTransaction();

        try {

            $subtotal = 0;

            $sale = Sale::create([
                'invoice_number' => 'INV-' . time(),
                'customer_id' => $request->customer_id,
                'subtotal' => 0,
                'discount' => 0,
                'tax' => 0,
                'total' => 0,
                'status' => 'pending',
                'payment_method' => $request->payment_method ?? 'cash',
                'notes' => $request->notes,
                'created_by' => auth()->id(),
            ]);

            foreach ($request->items as $item) {

                if (($item['quantity'] ?? 0) <= 0) {
                    continue;
                }

                $product = Product::find($item['product_id']);

                if (!$product) {
                    continue;
                }

                $lineTotal = $product->price * $item['quantity'];

                $subtotal += $lineTotal;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total' => $lineTotal,
                ]);

                $product->decrement('quantity', $item['quantity']);
            }

            if ($subtotal <= 0) {
                throw new \Exception('Please add product quantity');
            }

            $tax = $subtotal * 0.15;

            $sale->update([
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $subtotal + $tax,
            ]);

            DB::commit();

            return redirect()->route('sales.index')
                ->with('success', 'Order created successfully');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Sale $sale)
    {
        $sale->load('customer', 'items.product');

        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        return view('sales.edit', compact('sale'));
    }

    public function update(Request $request, Sale $sale)
    {
        $sale->update([
            'status' => $request->status
        ]);

        return redirect()->route('sales.index');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()->route('sales.index');
    }
}