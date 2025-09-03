<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Invoice Penjualan</h2>
    <p><strong>Tanggal:</strong> {{ $sale->created_at->format('d-m-Y') }}</p>
    <p><strong>Customer:</strong> {{ $sale->customer->nama ?? '-' }}</p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->details as $item)
                <tr>
                    <td>{{ $item->product->nama ?? '-' }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total: Rp {{ number_format($sale->total, 0, ',', '.') }}</h3>
</body>
</html>
