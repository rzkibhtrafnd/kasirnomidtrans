<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KasirService
{
    public function getAll()
    {
        return User::where('role', 'kasir')
            ->latest()
            ->paginate(7);
    }

    public function store(array $data): User
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make('password'),
            'role'     => 'kasir',
        ]);
    }

    public function find(int $id): User
    {
        return User::findOrFail($id);
    }

    public function update(int $id, array $data): bool
    {
        $kasir = $this->find($id);

        return $kasir->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function delete(int $id): bool
    {
        return User::findOrFail($id)->delete();
    }
}