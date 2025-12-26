<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 6px;
            font-family: "DejaVu Sans Mono", monospace;
            font-size: 10px;
            color: #000;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 6px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        img.logo {
            width: 70px;
            height: auto;
            filter: grayscale(100%);
            margin-bottom: 4px;
        }

        td.item-name {
            width: 60%;
        }

        td.qty, td.price {
            width: 20%;
        }

        th {
            text-align: left;
            padding-bottom: 2px;
        }
    </style>
</head>

<body>

    @php
        $setting = \App\Models\Setting::first();
    @endphp
    
    {{-- Header --}}
    <div class="center">
        @if($setting->img_logo)
            <img src="{{ public_path('storage/settings/' . $setting->img_logo) }}" alt="Logo" class="logo"><br>
        @endif
        <strong>{{ $setting->company_name ?? 'Sistem Kasir' }}</strong><br>
        STRUK PEMBELIAN
    </div>

    <hr>

    {{-- Informasi Perusahaan --}}
    <div class="center">
        {{ $setting->address ?? '' }}<br>
        {{ $setting->phone ?? '' }}<br>
        {{ $setting->email ?? '' }}
    </div>

    <hr>

    {{-- Informasi Transaksi --}}
    <div>
        ID : {{ $transaction->id }}<br>
        Tanggal : {{ $transaction->created_at->format('d M Y H:i') }}<br>
        Kasir : {{ $transaction->user->name }}<br>
        Metode Pembayaran : @if($transaction->payment_method === 'midtrans')
            QRIS
        @else
            {{ ucfirst($transaction->payment_method) }}
        @endif
    </div>

    <hr>

    {{-- Daftar Item --}}
    <table>
        <tr>
            <th class="item-name">Produk</th>
            <th class="qty">Qty</th>
            <th class="price">Harga</th>
        </tr>
        @foreach ($transaction->items as $item)
            <tr>
                <td class="item-name">{{ $item->product->name }}</td>
                <td class="qty" class="right">{{ $item->qty }}x</td>
                <td class="price" class="right">Rp{{ number_format($item->price) }}</td>
            </tr>
        @endforeach
    </table>

    <hr>

    {{-- Total --}}
    <div class="right">
        <strong>
            TOTAL: Rp{{ number_format($transaction->total) }}
        </strong>
    </div>

    <hr>

    {{-- Footer --}}
    <div class="center">
        Terima kasih<br>
        Struk dicetak otomatis<br>
        @if($setting->wifi && $setting->wifi_password)
            WiFi: {{ $setting->wifi }}<br>
            Password: {{ $setting->wifi_password }}
        @endif
    </div>

</body>
</html>
