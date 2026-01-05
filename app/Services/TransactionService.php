<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function getAll(User $user, ?int $month = null,?int $year = null,)
    {
        return Transaction::with('user')
            ->forUser($user)
            ->filterByDate($month, $year)
            ->latest()
            ->paginate(9);
    }

    public function store(array $data): Transaction
    {
        $cart = json_decode($data['cart'], true);

        if (empty($cart)) {
            throw new \DomainException('Keranjang kosong');
        }

        return DB::transaction(function () use ($cart, $data) {

            $total = collect($cart)
                ->sum(fn ($item) => $item['qty'] * $item['price']);

            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'payment_method' => $data['payment_method'],
                'payment_status' => 'paid',
            ]);

            $transaction->items()->createMany(
                collect($cart)->map(fn ($item) => [
                    'product_id' => $item['id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['qty'] * $item['price'],
                ])->toArray()
            );

            return $transaction;
        });
    }

    public function show(Transaction $transaction, User $user): Transaction
    {
        $this->authorize($transaction, $user);

        return $transaction->load('items.product');
    }

    public function receipt(Transaction $transaction, User $user): Transaction
    {
        $this->authorize($transaction, $user);

        return $transaction->load(['items.product', 'user']);
    }

    public function report(?int $month, ?int $year)
    {
        return Transaction::with('user')
            ->filterByDate($month, $year)
            ->latest()
            ->get();
    }

    private function authorize(Transaction $transaction, User $user): void
    {
        if ($user->role === 'admin') {
            return;
        }

        if ($transaction->user_id !== $user->id) {
            abort(403);
        }
    }
}
