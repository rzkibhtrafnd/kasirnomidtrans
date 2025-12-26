<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard sesuai role user
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return $this->adminDashboard();
        }

        if ($user->role === 'kasir') {
            return $this->kasirDashboard();
        }

        abort(403, 'Unauthorized');
    }

    /**
     * Dashboard untuk admin
     */
    private function adminDashboard()
    {
        $categoriesCount    = Category::count();
        $productsCount      = Product::count();
        $transactionsCount  = Transaction::count();
        $totalRevenue       = Transaction::sum('total');
        $recentTransactions = Transaction::with('user')
                                        ->latest()
                                        ->take(5)
                                        ->get();

        // Top Produk Terlaris
        $topProducts = Product::withSum('transactionItems as total_sold', 'qty')
                              ->withSum('transactionItems as total_revenue', DB::raw('qty * price'))
                              ->orderByDesc('total_sold')
                              ->take(5)
                              ->get();

        return view('admin.dashboard', compact(
            'categoriesCount',
            'productsCount',
            'transactionsCount',
            'totalRevenue',
            'recentTransactions',
            'topProducts'
        ));
    }

    /**
     * Dashboard untuk kasir
     */
    private function kasirDashboard()
    {
        $user = Auth::user();

        $myTransactionsCount  = Transaction::where('user_id', $user->id)->count();
        $myRevenue            = Transaction::where('user_id', $user->id)->sum('total');
        $myRecentTransactions = Transaction::where('user_id', $user->id)
                                           ->latest()
                                           ->take(10)
                                           ->get();

        return view('kasir.dashboard', compact(
            'myTransactionsCount',
            'myRevenue',
            'myRecentTransactions'
        ));
    }
}
