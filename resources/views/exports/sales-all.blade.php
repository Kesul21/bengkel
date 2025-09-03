<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Laporan Seluruh Penjualan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Total</th>
               
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $index => $sale)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $sale->created_at->format('d-m-Y') }}</td>
                    <td>{{ $sale->customer->nama ?? '-' }}</td>
                    <td>Rp {{ number_format($sale->harga_satuan, 0, ',', '.') }}</td>
                   
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
