<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 20px;
        }
        h2, h3 {
            text-align: center;
            margin: 0;
        }
        p.company-info {
            text-align: center;
            font-size: 11px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        tfoot td {
            font-weight: bold;
        }
        .right {
            text-align: right;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 5px;
        }
        img.logo {
            width: 70px;
            height: auto;
            filter: grayscale(100%);
        }
    </style>
</head>
<body>

    {{-- Ambil Setting --}}
    @php
        $setting = \App\Models\Setting::first();
    @endphp

    {{-- Logo --}}
    @if($setting && $setting->img_logo)
        <div class="logo-container">
            <img src="{{ public_path('storage/settings/' . $setting->img_logo) }}" alt="Logo" class="logo">
        </div>
    @endif

    <h2>{{ $setting->company_name ?? 'Sistem Kasir' }}</h2>
    <p class="company-info">
        {{ $setting->address ?? '' }} <br>
        Telp: {{ $setting->phone ?? '' }} | Email: {{ $setting->email ?? '' }}
    </p>

    <h3>Laporan Transaksi</h3>

    @if(request('month') || request('year'))
        <p style="text-align: center;">
            Filter: 
            @if(request('month')) Bulan {{ DateTime::createFromFormat('!m', request('month'))->format('F') }} @endif
            @if(request('year')) Tahun {{ request('year') }} @endif
        </p>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Total</th>
                <th>Pembayaran</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($transactions as $transaction)
                <tr>
                    <td>#{{ $transaction->id }}</td>
                    <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($transaction->payment_method) }}</td>
                    <td>{{ ucfirst($transaction->payment_status) }}</td>
                </tr>
                @php $grandTotal += $transaction->total; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="right">Total Keseluruhan</td>
                <td class="right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

    <p style="margin-top: 20px; font-size: 11px;">
        Dicetak pada: {{ date('d-m-Y H:i') }}
    </p>
</body>
</html>
