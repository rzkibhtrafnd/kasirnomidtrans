<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'total', 'payment_method', 'payment_status'];

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilterByDate($query, $month, $year)
    {
        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        return $query;
    }

    public function scopeForUser($query, $user)
    {
        if ($user->role === 'admin') {
            return $query;
        }

        return $query->where('user_id', $user->id);
    }
}
