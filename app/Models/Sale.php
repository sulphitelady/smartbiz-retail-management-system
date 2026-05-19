<?php
namespace App\Models;
 
use Illuminate\Database\Eloquent\{Model, Factories\HasFactory};
 
class Sale extends Model
{
    use HasFactory;
    protected $fillable = ['invoice_number','customer_id','subtotal','discount','tax','total','payment_method','notes','status','created_by'];
    protected $casts    = ['subtotal'=>'decimal:2','discount'=>'decimal:2','tax'=>'decimal:2','total'=>'decimal:2'];
 
    public function customer()  { return $this->belongsTo(Customer::class); }
    public function items()     { return $this->hasMany(SaleItem::class); }
    public function createdBy() { return $this->belongsTo(User::class, 'created_by'); }
}