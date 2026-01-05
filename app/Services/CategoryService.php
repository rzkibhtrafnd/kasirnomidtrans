<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getAll()
    {
        return Category::latest()->paginate(7);
    }

    public function store(array $data): Category
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data): bool
    {
        return $category->update($data);
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }
}