<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingRequest;
use App\Services\SettingService;

class SettingController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    public function index()
    {
        $setting = $this->settingService->get();
        return view('admin.settings.index', compact('setting'));
    }

    public function update(UpdateSettingRequest $request)
    {
        $this->settingService->updateOrCreate(
            $request->validated()
        );

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
