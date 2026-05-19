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
            'currency'        => 'USD',
            'tax_rate'        => '15',
            'low_stock_alert' => '10',
            'timezone'        => 'UTC',
            'date_format'     => 'MM/DD/YYYY',
        ];
        foreach ($settings as $key => $val) {
            Setting::create(['key'=>$key,'value'=>$val]);
        }
    }
}