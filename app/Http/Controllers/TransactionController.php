<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Transaction;
use App\Services\TransactionService;
use App\Http\Requests\StoreTransactionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService
    ) {}

    public function index(Request $request)
    {
        $transactions = $this->transactionService->getAll(
            Auth::user(),
            $request->month,
            $request->year
        );

        return view('transactions.index', compact('transactions'));
    }

    public function create(Request $request)
    {
        return view('transactions.create', [
            'products' => Product::filter($request)->paginate(6)->withQueryString(),
            'categories' => Category::all(),
            'setting' => Setting::first(),
        ]);
    }

    public function store(StoreTransactionRequest $request)
    {
        $transaction = $this->transactionService->store($request->validated());

        return response()->json([
            'success'  => true,
            'redirect' => route('transactions.show', $transaction),
        ]);
    }

    public function show(Transaction $transaction)
    {
        $transaction = $this->transactionService->show(
            $transaction,
            Auth::user()
        );

        return view('transactions.show', compact('transaction'));
    }

    public function downloadPdf(Transaction $transaction)
    {
        $transaction = $this->transactionService->receipt(
            $transaction,
            Auth::user()
        );

        return Pdf::loadView('transactions.receipt', compact('transaction'))
            ->setPaper([0, 0, 165, 1000])
            ->stream('struk.pdf');
    }

    public function downloadReportPdf(Request $request)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $transactions = $this->transactionService->report(
            $request->month,
            $request->year
        );

        return Pdf::loadView('transactions.report', compact('transactions'))
            ->setPaper('a4')
            ->download('laporan_transaksi.pdf');
    }
}

