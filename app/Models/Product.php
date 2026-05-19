<?php
namespace App\Models;
 
use Illuminate\Database\Eloquent\{Model, Factories\HasFactory, SoftDeletes};
 
class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name','sku','category_id','price','quantity','supplier','description','image'];
    protected $casts    = ['price' => 'decimal:2'];
 
    public function category()      { return $this->belongsTo(Category::class); }
    public function saleItems()     { return $this->hasMany(SaleItem::class); }
    public function inventoryLogs() { return $this->hasMany(InventoryLog::class); }
    public function getImageUrlAttribute() { return $this->image ? asset('storage/'.$this->image) : null; }
    public function scopeLowStock($q) { return $q->where('quantity','>', 0)->where('quantity','<=', 10); }
    public function isLowStock()    { return $this->quantity > 0 && $this->quantity <= 10; }
    public function isOutOfStock()  { return $this->quantity === 0; }
    public function getStockStatusAttribute() {
        if ($this->quantity === 0) return 'Out of Stock';
        if ($this->quantity <= 10) return 'Low Stock';
        return 'In Stock';
    }
}