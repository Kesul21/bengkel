<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { border-bottom: 1px dotted #000; padding: 4px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h3 style="text-align: center;">BENGKEL MOTOR FANET</h3>
    <p>Tanggal: {{ $sale->created_at->format('d/m/Y') }}</p>
    <p>Customer: {{ $sale->customer->name ?? '-' }}</p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->saleItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">Rp{{ number_format($item->price) }}</td>
                    <td class="text-right">Rp{{ number_format($item->subtotal) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="text-right">Total: Rp{{ number_format($sale->total_price) }}</h4>

    <p class="text-center">Terima kasih atas pembelian Anda.</p>
</body>
</html>
