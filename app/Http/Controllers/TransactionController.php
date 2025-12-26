<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Transaction::with('user');

        // Filter berdasarkan bulan/tahun
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // Role Admin
        if ($user->role === 'admin') {
            $transactions = $query->latest()->paginate(9);
        } 
        // Role Kasir
        else {
            $transactions = $query->where('user_id', $user->id)
                                ->latest()
                                ->paginate(9);
        }

        return view('transactions.index', compact('transactions'));
    }

    public function create(Request $request)
    {
        $query = Product::query();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return view('transactions.create', [
            'products' => $query->latest()->paginate(6)->withQueryString(),
            'categories' => Category::all(),
            'setting' => Setting::first(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|json',
            'payment_method' => 'required|in:cash,qris'
        ]);

        $cart = json_decode($request->cart, true);
        if (empty($cart)) {
            return response()->json(['error' => 'Keranjang kosong'], 422);
        }

        $total = collect($cart)->sum(fn($i) => $i['qty'] * $i['price']);

        DB::beginTransaction();

        try {
            $trx = Transaction::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => 'paid'
            ]);

            foreach ($cart as $item) {
                TransactionItem::create([
                    'transaction_id' => $trx->id,
                    'product_id' => $item['id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['qty'] * $item['price'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'transaction_id' => $trx->id,
                'redirect' => route('transactions.show', $trx),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function show(Transaction $transaction)
    {
        abort_if($transaction->user_id !== Auth::id(), 403);
        $transaction->load('items.product');

        return view('transactions.show', compact('transaction'));
    }

    public function downloadPdf(Transaction $transaction)
    {
        abort_if($transaction->user_id !== Auth::id(), 403);

        $transaction->load(['items.product', 'user']);

        $pdf = Pdf::loadView('transactions.receipt', compact('transaction'));
        $pdf->setPaper([0, 0, 165, 1000], 'portrait');

        return $pdf->stream('struk.pdf');
    }

    public function downloadReportPdf(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            abort(403);
        }

        $query = Transaction::with('user');

        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $transactions = $query->latest()->get();

        $pdf = Pdf::loadView('transactions.report', compact('transactions'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('laporan_transaksi.pdf');
    }
}
