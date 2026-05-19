<?php
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use App\Models\Category;
 
class CategorySeeder extends Seeder
{
    public function run()
    {
        $cats = [
            ['name'=>'Electronics','description'=>'Electronic devices and accessories','color'=>'#6366f1'],
            ['name'=>'Clothing','description'=>'Apparel and fashion items','color'=>'#8b5cf6'],
            ['name'=>'Food & Beverage','description'=>'Food and drink products','color'=>'#10b981'],
            ['name'=>'Home & Garden','description'=>'Home improvement and garden','color'=>'#f59e0b'],
            ['name'=>'Sports','description'=>'Sports and fitness equipment','color'=>'#ec4899'],
            ['name'=>'Health','description'=>'Health and wellness products','color'=>'#3b82f6'],
        ];
        foreach ($cats as $cat) Category::create($cat);
    }
}