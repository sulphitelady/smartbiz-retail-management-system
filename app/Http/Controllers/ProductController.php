<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\{Product, Category, InventoryLog};
 
class ProductController extends Controller
{
    public function create()
{
    $categories = Category::all();
    return view('products.create', compact('categories'));
}

public function edit(Product $product)
{
    $categories = Category::all();
    return view('products.edit', compact('product', 'categories'));
}
    public function index(Request $request) {
        $query = Product::with('category');
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(fn($b) => $b->where('name','like',"%$q%")->orWhere('sku','like',"%$q%"));
        }
        if ($request->filled('category')) $query->where('category_id', $request->category);
        if ($request->filled('status')) {
            if ($request->status === 'low')  $query->where('quantity', '>', 0)->where('quantity', '<=', 10);
            if ($request->status === 'out')  $query->where('quantity', 0);
            if ($request->status === 'good') $query->where('quantity', '>', 10);
        }
        $products   = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();
        $invStats   = [
            'total'  => Product::count(),
            'low'    => Product::lowStock()->count(),
            'out'    => Product::where('quantity', 0)->count(),
            'value'  => Product::selectRaw('SUM(price * quantity) as total_value')->value('total_value'),
        ];
        return view('products.index', compact('products', 'categories', 'invStats'));
    }
 
    public function store(Request $request) {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'sku'         => 'required|string|unique:products|max:50',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'supplier'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }
        $product = Product::create($validated);
        InventoryLog::create(['product_id' => $product->id, 'action' => 'added', 'quantity_change' => $product->quantity, 'note' => 'Initial stock']);
        return redirect()->route('products.index')->with('success', 'Product added!');
    }
 
    public function update(Request $request, Product $product) {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'sku'         => 'required|string|unique:products,sku,' . $product->id . '|max:50',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'supplier'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $oldQty = $product->quantity;
        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $validated['image'] = $request->file('image')->store('products', 'public');
        }
        $product->update($validated);
        if ($product->quantity !== $oldQty) {
            InventoryLog::create(['product_id' => $product->id, 'action' => 'adjusted', 'quantity_change' => $product->quantity - $oldQty, 'note' => 'Manual adjustment']);
        }
        return redirect()->route('products.index')->with('success', 'Product updated!');
    }
 
    public function destroy(Product $product) {
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
 
    public function updateStock(Request $request, Product $product) {
        $request->validate(['quantity' => 'required|integer|min:0', 'note' => 'nullable|string|max:255']);
        $change = $request->quantity - $product->quantity;
        $product->update(['quantity' => $request->quantity]);
        InventoryLog::create(['product_id' => $product->id, 'action' => 'adjusted', 'quantity_change' => $change, 'note' => $request->note ?? 'Stock update']);
        return back()->with('success', 'Stock updated!');
    }
}