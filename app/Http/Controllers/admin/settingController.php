<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class settingController extends Controller
{
    public function pageSetting()
    {
        return view('admin.itemMenu.setting');
    }

    public function save(Request $request)
    {
        $request->validate([
            'restaurant_name' => 'nullable|string|max:255',
            'phone'           => 'nullable|string|max:50',
            'email'           => 'nullable|email|max:255',
            'address'         => 'nullable|string|max:500',
            'currency'        => 'nullable|string|max:20',
            'timezone'        => 'nullable|string|max:100',
            'kitchen_printer' => 'nullable|ip',
            'receipt_printer' => 'nullable|ip',
        ]);

        // TODO: persist to database once settings table exists
        // Setting::updateOrCreate(['key' => ...], ['value' => ...]);

        return redirect()->route('setting.index')
            ->with('success', 'Settings saved successfully.');
    }
}