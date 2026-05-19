<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Auth, Storage};
use App\Models\User;
 
class SettingsController extends Controller
{
    public function index() { return view('settings.index', ['user' => Auth::user()]); }
 
    public function updateProfile(Request $request) {
        $user = Auth::user();
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'phone'  => 'nullable|string|max:20',
            'address'=> 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $validated['avatar'] = $request->file('avatar')->store('avatars','public');
        }
        $user->update($validated);
        return back()->with('success', 'Profile updated!');
    }
 
    public function updatePassword(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        Auth::user()->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password updated successfully!');
    }
 
    public function updateSystem(Request $request) {
        $settings = $request->validate([
            'business_name'   => 'required|string|max:255',
            'currency'        => 'required|string|max:10',
            'tax_rate'        => 'required|numeric|min:0|max:100',
            'low_stock_alert' => 'required|integer|min:1',
            'timezone'        => 'required|string',
            'date_format'     => 'required|string',
        ]);
        foreach ($settings as $key => $val) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $val]);
        }
        return back()->with('success', 'System settings saved!');
    }
 
    public function updateNotifications(Request $request) {
        $notifs = ['low_stock_alerts','new_sale_notifications','new_customer_alerts','daily_summary','system_alerts'];
        foreach ($notifs as $notif) {
            Auth::user()->notifications()->updateOrCreate(['type' => $notif], ['enabled' => $request->boolean($notif)]);
        }
        return back()->with('success', 'Notification preferences saved!');
    }
}