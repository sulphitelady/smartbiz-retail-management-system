<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Customer;
 
class CustomerController extends Controller
{   
    public function create()
{
    return view('customers.create');
}
    public function index(Request $request) {
        $query = Customer::withCount('sales');
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function($builder) use ($q) {
                $builder->where('name','like',"%$q%")->orWhere('email','like',"%$q%")->orWhere('phone','like',"%$q%");
            });
        }
        $customers = $query->latest()->paginate(15)->withQueryString();
        return view('customers.index', compact('customers'));
    }
 
    public function store(Request $request) {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:customers',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);
        Customer::create($validated);
        return redirect()->route('customers.index')->with('success', 'Customer added successfully!');
    }
 
    public function show(Customer $customer) {
        $customer->load(['sales.items.product']);
        return view('customers.show', compact('customer'));
    }
 
    public function edit(Customer $customer) { return view('customers.edit', compact('customer')); }
 
    public function update(Request $request, Customer $customer) {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:customers,email,' . $customer->id,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);
        $customer->update($validated);
        return redirect()->route('customers.index')->with('success', 'Customer updated!');
    }
 
    public function destroy(Customer $customer) {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted.');
    }
 
    public function history(Customer $customer) {
        $sales = $customer->sales()->with('items.product')->latest()->paginate(10);
        return view('customers.history', compact('customer', 'sales'));
    }
}