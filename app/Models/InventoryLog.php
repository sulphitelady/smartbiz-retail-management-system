<?php
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class InventoryLog extends Model
{
    protected $fillable = ['product_id','action','quantity_change','note','sale_id'];
    public function product() { return $this->belongsTo(Product::class); }
    public function sale()    { return $this->belongsTo(Sale::class); }
}