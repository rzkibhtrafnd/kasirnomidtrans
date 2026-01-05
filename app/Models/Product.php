<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'image', 'price'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function scopeFilter($query, $request)
    {
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        return $query->latest();
    }

}

