<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function pageSetting()
    {
        $settings = [
            'restaurant_name' => Setting::get('restaurant_name', 'FastBite'),
            'tagline'         => Setting::get('tagline', 'Flavor Unleashed.'),
            'description'     => Setting::get('description', 'The best chefs in the city, delivered to your door in under 30 minutes.'),
            'phone'           => Setting::get('phone'),
            'email'           => Setting::get('email'),
            'address'         => Setting::get('address'),
            'currency'        => Setting::get('currency', 'USD'),
            'timezone'        => Setting::get('timezone', 'Asia/Phnom_Penh'),
            'hero_image'      => Setting::get('hero_image'),
            'logo_text'       => Setting::get('logo_text', 'FastBite'),
            'delivery_time'   => Setting::get('delivery_time', '30'),
            'total_dishes'    => Setting::get('total_dishes', '200+'),
            'happy_customers' => Setting::get('happy_customers', '10K+'),
            'rating'          => Setting::get('rating', '4.9'),
        ];

        return view('admin.itemMenu.setting', compact('settings'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'restaurant_name' => 'nullable|string|max:255',
            'tagline'         => 'nullable|string|max:255',
            'description'     => 'nullable|string|max:500',
            'phone'           => 'nullable|string|max:50',
            'email'           => 'nullable|email|max:255',
            'address'         => 'nullable|string|max:500',
            'currency'        => 'nullable|string|max:20',
            'timezone'        => 'nullable|string|max:100',
            'logo_text'       => 'nullable|string|max:100',
            'delivery_time'   => 'nullable|string|max:20',
            'total_dishes'    => 'nullable|string|max:20',
            'happy_customers' => 'nullable|string|max:20',
            'rating'          => 'nullable|string|max:10',
            'hero_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        
        if ($request->hasFile('hero_image')) {
            
            $old = Setting::get('hero_image');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $path = $request->file('hero_image')->store('settings', 'public');
            Setting::set('hero_image', $path);
        }

        
        $fields = ['restaurant_name', 'tagline', 'description', 'phone', 'email',
                   'address', 'currency', 'timezone', 'logo_text',
                   'delivery_time', 'total_dishes', 'happy_customers', 'rating'];

        foreach ($fields as $key) {
            Setting::set($key, $request->input($key));
        }

        return redirect()->route('setting.index')
            ->with('success', 'Settings saved successfully.');
    }

    public function deleteImage()
    {
        $old = Setting::get('hero_image');
        if ($old && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }
        Setting::set('hero_image', null);

        return redirect()->route('setting.index')
            ->with('success', 'Hero image removed.');
    }
}