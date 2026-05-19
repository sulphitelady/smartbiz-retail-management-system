<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    ProfileController,
    ProductController,
    InventoryController,
    SaleController,
    CustomerController,
    DashboardController,
    ReportController
};

use App\Http\Controllers\Admin\UserApprovalController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| DASHBOARD (ONLY APPROVED USERS)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'approved'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USERS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'approved'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | ADMIN APPROVAL SYSTEM
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:admin'])->group(function () {

        Route::get('/admin/users/pending', [UserApprovalController::class, 'index'])
            ->name('admin.users.pending');

        Route::post('/admin/users/{id}/approve', [UserApprovalController::class, 'approve'])
            ->name('admin.users.approve');
        
        Route::delete('/admin/users/{id}/reject', [UserApprovalController::class, 'reject'])
            ->name('admin.users.reject');
    });

});

    /*
    |--------------------------------------------------------------------------
    | PRODUCTS (ADMIN ONLY)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin|manager')->group(function () {

    Route::resource('products', ProductController::class);

});

    /*
    |--------------------------------------------------------------------------
    | CUSTOMERS (ADMIN + MANAGER + STAFF)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin|manager|staff')->group(function () {
        Route::resource('customers', CustomerController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | SALES (ADMIN + MANAGER + STAFF)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin|manager|staff')->group(function () {

        Route::resource('sales', SaleController::class);

        Route::post('/sales/{sale}/cancel', [SaleController::class, 'destroy'])
            ->name('sales.cancel');

        Route::post('/sales/{sale}/status', [SaleController::class, 'updateStatus'])
            ->name('sales.status');
    });

    /*
    |--------------------------------------------------------------------------
    | INVENTORY (ADMIN + MANAGER)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin|manager')->group(function () {

        Route::get('/inventory', [InventoryController::class, 'index'])
            ->name('inventory');
    });

    /*
    |--------------------------------------------------------------------------
    | REPORTS (ADMIN + MANAGER)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin|manager')->group(function () {

        Route::get('/reports', [ReportController::class, 'index'])->name('reports');

        Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');

        Route::get('/reports/sales/export-csv', [ReportController::class, 'exportSalesCSV'])
            ->name('reports.sales.csv');

        Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');

        Route::get('/reports/inventory/export-csv', [ReportController::class, 'exportInventoryCSV'])
            ->name('reports.inventory.csv');

        Route::get('/reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');

        Route::get('/reports/revenue/export-csv', [ReportController::class, 'exportRevenueCSV'])
            ->name('reports.revenue.csv');

        Route::get('/reports/top-products', [ReportController::class, 'topProducts'])->name('reports.top-products');

        Route::get('/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
    });

    /*
    |--------------------------------------------------------------------------
    | SETTINGS (ADMIN ONLY)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {
        Route::view('/settings', 'settings.index')->name('settings');
    });

});