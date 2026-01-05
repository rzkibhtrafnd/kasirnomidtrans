<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    public function getAll()
    {
        return Product::latest()->paginate(7);
    }

    public function store(array $data): Product
    {
        if (isset($data['image'])) {
            $data['image'] = request()
                ->file('image')
                ->store('products', 'public');
        }

        return Product::create($data);
    }

    public function update(Product $product, array $data): bool
    {
        if (isset($data['image'])) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = request()
                ->file('image')
                ->store('products', 'public');
        }

        return $product->update($data);
    }

    public function delete(Product $product): bool
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        return $product->delete();
    }
}
