<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DashboardService
{
    public function admin(): array
    {
        return [
            'categoriesCount'   => Category::count(),
            'productsCount'     => Product::count(),
            'transactionsCount' => Transaction::count(),
            'totalRevenue'      => Transaction::sum('total'),
            'recentTransactions'=> Transaction::with('user')
                                        ->latest()
                                        ->limit(5)
                                        ->get(),
            'topProducts'       => Product::withSum(
                                        'transactionItems as total_sold',
                                        'qty'
                                    )
                                    ->withSum(
                                        'transactionItems as total_revenue',
                                        DB::raw('qty * price')
                                    )
                                    ->orderByDesc('total_sold')
                                    ->limit(5)
                                    ->get(),
        ];
    }

    public function kasir(User $user): array
    {
        return [
            'myTransactionsCount'  => Transaction::whereUserId($user->id)->count(),
            'myRevenue'            => Transaction::whereUserId($user->id)->sum('total'),
            'myRecentTransactions' => Transaction::whereUserId($user->id)
                                        ->latest()
                                        ->limit(10)
                                        ->get(),
        ];
    }
}
