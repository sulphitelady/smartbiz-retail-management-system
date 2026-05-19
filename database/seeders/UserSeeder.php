<?php
namespace Database\Seeders;
 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
 
class UserSeeder extends Seeder
{
    public function run()
    {
        User::create(['name'=>'Administrator','email'=>'admin@smartbiz.com','password'=>Hash::make('password'),'role'=>'admin','phone'=>'+1 555-0001']);
        User::create(['name'=>'Manager User','email'=>'manager@smartbiz.com','password'=>Hash::make('password'),'role'=>'manager','phone'=>'+1 555-0002']);
        User::create(['name'=>'Staff User','email'=>'staff@smartbiz.com','password'=>Hash::make('password'),'role'=>'staff','phone'=>'+1 555-0003']);
    }
}