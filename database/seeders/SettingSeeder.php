<?php
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use App\Models\Setting;
 
class SettingSeeder extends Seeder
{
    public function run()
{
    $settings = [
        'business_name'   => 'SmartBiz Retail Co.',
        'currency'        => 'AED',
        'tax_rate'        => '5',
        'low_stock_alert' => '10',
        'timezone'        => 'Asia/Dubai',
        'date_format'     => 'd/m/Y',
    ];

    foreach ($settings as $key => $val) {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $val]
        );
    }
}
}