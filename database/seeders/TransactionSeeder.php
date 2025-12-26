<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user kasir
        $kasir = User::where('role', 'kasir')->first();

        if (!$kasir) {
            $this->command->error('User kasir tidak ditemukan');
            return;
        }

        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->error('Produk belum ada');
            return;
        }

        // Buat 20 transaksi
        for ($i = 1; $i <= 20; $i++) {

            DB::transaction(function () use ($kasir, $products) {

                // Buat transaksi
                $transaction = Transaction::create([
                    'user_id'        => $kasir->id,
                    'total'          => 0,
                    'payment_method' => collect(['cash', 'qris'])->random(),
                    'payment_status' => 'paid',
                ]);

                $total = 0;

                // Ambil 2–5 produk acak
                $items = $products->random(rand(2, 5));

                foreach ($items as $product) {
                    $qty = rand(1, 3);
                    $subtotal = $product->price * $qty;

                    TransactionItem::create([
                        'transaction_id' => $transaction->id,
                        'product_id'     => $product->id,
                        'qty'            => $qty,
                        'price'          => $product->price,
                        'subtotal'       => $subtotal,
                    ]);

                    $total += $subtotal;
                }

                // Update total transaksi
                $transaction->update([
                    'total' => $total
                ]);
            });
        }
    }
}
