<?php
namespace App\Models;
 
use Illuminate\Database\Eloquent\{Model, Factories\HasFactory, SoftDeletes};
 
class Customer extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name','email','phone','address'];
    public function sales()       { return $this->hasMany(Sale::class); }
    public function totalSpent()  { return $this->sales()->sum('total'); }
    
}
