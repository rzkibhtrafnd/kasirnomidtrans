<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreKasirRequest;
use App\Http\Requests\Admin\UpdateKasirRequest;
use App\Services\KasirService;

class KasirController extends Controller
{
    protected KasirService $kasirService;

    public function __construct(KasirService $kasirService)
    {
        $this->kasirService = $kasirService;
    }

    public function index()
    {
        $kasirs = $this->kasirService->getAll();
        return view('admin.kasir.index', compact('kasirs'));
    }

    public function create()
    {
        return view('admin.kasir.create');
    }

    public function store(StoreKasirRequest $request)
    {
        $this->kasirService->store($request->validated());

        return redirect()
            ->route('admin.kasir.index')
            ->with('success', 'Kasir berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kasir = $this->kasirService->find($id);
        return view('admin.kasir.edit', compact('kasir'));
    }

    public function update(UpdateKasirRequest $request, $id)
    {
        $this->kasirService->update($id, $request->validated());

        return redirect()
            ->route('admin.kasir.index')
            ->with('success', 'Kasir berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->kasirService->delete($id);

        return redirect()
            ->route('admin.kasir.index')
            ->with('success', 'Kasir berhasil dihapus.');
    }
}
