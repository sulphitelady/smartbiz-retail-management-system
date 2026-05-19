<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\{Sale, Product, Customer, InventoryLog};
use Carbon\Carbon;
 
class ReportController extends Controller
{
    public function index() { return view('reports.index'); }
 
    public function sales(Request $request)
{
    $query = Sale::with(['customer']);

    // FILTER START DATE
    if ($request->filled('date_from')) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }

    // FILTER END DATE
    if ($request->filled('date_to')) {
        $query->whereDate('created_at', '<=', $request->date_to);
    }

    $sales = $query->latest()->get();

    $stats = [
        'total' => $sales->count(),
        'revenue' => $sales->sum('total'),
        'avg_order' => $sales->count() ? $sales->avg('total') : 0,
        'card_payments' => $sales->where('payment_method', 'card')->count(),
    ];

    return view('reports.sales', compact('sales', 'stats'));
}
 
    public function inventory(Request $request) {
        $products = Product::with('category')->get();
        $stats = ['total' => $products->count(), 'value' => $products->sum(fn($p) => $p->price * $p->quantity), 'low_stock' => $products->where('quantity','<=',10)->where('quantity','>',0)->count(), 'out_of_stock' => $products->where('quantity',0)->count()];
        return view('reports.inventory', compact('products','stats'));
    }
    public function exportInventoryCSV()
{
    $products = Product::with('category')->get();

    $filename = 'inventory-report.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=$filename",
    ];

    $callback = function () use ($products) {

        $file = fopen('php://output', 'w');

        fputcsv($file, [
            'Product',
            'SKU',
            'Quantity',
            'Price',
            'Value'
        ]);

        foreach ($products as $p) {

            fputcsv($file, [
                $p->name,
                $p->sku,
                $p->quantity,
                $p->price,
                $p->price * $p->quantity
            ]);

        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
 
    public function revenue(Request $request) {
        $year = $request->year ?? now()->year;
        $monthly = Sale::selectRaw('MONTH(created_at) as month, SUM(total) as revenue, COUNT(*) as count')->whereYear('created_at',$year)->groupBy('month')->orderBy('month')->get()->keyBy('month');
        $total = $monthly->sum('revenue');
        return view('reports.revenue', compact('monthly','total','year'));
    }
    public function topProducts()
{
    $products = \App\Models\SaleItem::join('products', 'sale_items.product_id', '=', 'products.id')
        ->selectRaw('
            products.id,
            products.name,
            SUM(sale_items.quantity) as total_qty,
            SUM(sale_items.total) as revenue
        ')
        ->groupBy('products.id', 'products.name')
        ->orderByDesc('total_qty')
        ->get();

    return view('reports.top-products', compact('products'));
}
    public function customers(Request $request) {
        $customers = Customer::withCount('sales')->withSum('sales','total')->orderByDesc('sales_count')->get();
        $stats = ['total' => $customers->count(), 'purchases' => $customers->sum('sales_count'), 'avg' => $customers->avg('sales_count'), 'top_spender' => $customers->max('sales_sum_total')];
        return view('reports.customers', compact('customers','stats'));
    }
    public function exportSalesCSV(Request $request)
{
    $sales = Sale::with('customer')->latest()->get();

    $filename = 'sales-report.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=$filename",
    ];

    $callback = function () use ($sales) {

        $file = fopen('php://output', 'w');

        fputcsv($file, [
            'Date',
            'Customer',
            'Total'
        ]);

        foreach ($sales as $sale) {

            fputcsv($file, [
                $sale->created_at,
                $sale->customer->name ?? 'Walk-in',
                $sale->total
            ]);

        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
    public function exportRevenueCSV()
{
    $year = now()->year;

    $monthly = Sale::selectRaw('MONTH(created_at) as month, SUM(total) as revenue')
        ->whereYear('created_at', $year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    $filename = 'monthly-revenue-report.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=$filename",
    ];

    $callback = function () use ($monthly) {

        $file = fopen('php://output', 'w');

        fputcsv($file, ['Month', 'Revenue']);

        foreach ($monthly as $m) {

            fputcsv($file, [
                date('F', mktime(0,0,0,$m->month,1)),
                $m->revenue
            ]);

        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
    public function exportPDF(Request $request, $type) {
        // Using barryvdh/laravel-dompdf
        $data = $this->getReportData($type, $request);
        $pdf = \PDF::loadView("reports.pdf.{$type}", $data);
        return $pdf->download("smartbiz-{$type}-report.pdf");
    }
 
    public function exportExcel(Request $request, $type) {
        // Using maatwebsite/excel
        $export = "App\\Exports\\" . ucfirst($type) . 'Report';
        return \Excel::download(new $export($request), "smartbiz-{$type}-report.xlsx");
    }
 
    private function getReportData($type, $request) {
        return match($type) {
            'sales'     => ['sales'     => Sale::with('customer')->latest()->get()],
            'inventory' => ['products'  => Product::with('category')->get()],
            'revenue'   => ['monthly'   => Sale::selectRaw('MONTH(created_at) as m, SUM(total) as r')->groupBy('m')->get()],
            'customers' => ['customers' => Customer::withCount('sales')->get()],
            default     => [],
        };
    }
}