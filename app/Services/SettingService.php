<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SettingService
{
    public function get(): ?Setting
    {
        return Setting::first();
    }

    public function updateOrCreate(array $data): Setting
    {
        $setting = Setting::first();

        if (isset($data['img_logo'])) {
            $data['img_logo'] = $this->uploadImage(
                $data['img_logo'],
                'logo',
                $setting?->img_logo
            );
        }

        if (isset($data['img_qris'])) {
            $data['img_qris'] = $this->uploadImage(
                $data['img_qris'],
                'qris',
                $setting?->img_qris
            );
        }

        return Setting::updateOrCreate(
            ['id' => $setting?->id],
            $data
        );
    }

    private function uploadImage(
        UploadedFile $file,
        string $prefix,
        ?string $oldFile
    ): string {
        $filename = $prefix . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('settings', $filename, 'public');

        if ($oldFile) {
            Storage::disk('public')->delete('settings/' . $oldFile);
        }

        return $filename;
    }
}
