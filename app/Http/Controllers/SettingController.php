<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'wifi' => 'nullable|string|max:255',
            'wifi_password' => 'nullable|string|max:255',
            'img_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'img_qris'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $setting = Setting::first();

        $data = $request->all();

        // logo
        if ($request->hasFile('img_logo')) {
            $file = $request->file('img_logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('settings', $filename, 'public');

            $data['img_logo'] = $filename;

            if ($setting && $setting->img_logo) {
                Storage::disk('public')->delete('settings/' . $setting->img_logo);
            }
        }

        // qris
        if ($request->hasFile('img_qris')) {
            $file = $request->file('img_qris');
            $filename = 'qris_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('settings', $filename, 'public');

            $data['img_qris'] = $filename;
            if ($setting && $setting->img_qris) {
                Storage::disk('public')->delete('settings/' . $setting->img_qris);
            }
        }

        if($setting) {
            $setting->update($data);
        } else {
            Setting::create($data);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}