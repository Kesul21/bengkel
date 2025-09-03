<!DOCTYPE html>
<html>
<head>
    <title>Kwitansi Servis</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 13px;
            margin: 20px;
            color: #000;
        }
        .receipt-container {
            width: 320px;
            margin: auto;
            border: 1px solid #ccc;
            padding: 15px;
        }
        .center {
            text-align: center;
        }
        .dashed {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        table {
            width: 100%;
        }
        td, th {
            padding: 4px 0;
        }
        .right {
            text-align: right;
        }
        .left {
            text-align: left;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="center">
            <h3>BENGKEL MOTOR SEHAT</h3>
            <p>Jl. Contoh No. 123, Indramayu</p>
        </div>

        <div class="dashed"></div>

        <p><strong>Customer:</strong> {{ $service->customer->nama }}</p>
        <p><strong>Motor:</strong> {{ $service->motor }}</p>
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($service->tanggal)->format('d/m/Y') }}</p>

        <div class="dashed"></div>

        <table>
            <thead>
                <tr>
                    <th class="left">Produk</th>
                    <th class="right">Qty</th>
                    <th class="right">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($service->details as $detail)
                <tr>
                    <td class="left">{{ $detail->product->nama ?? '-' }}</td>
                    <td class="right">{{ $detail->qty }}</td>
                    <td class="right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="dashed"></div>

        <table>
            <tr>
                <td class="left bold">Total Sparepart</td>
                <td class="right bold">Rp {{ number_format($service->total_sparepart, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="left">Biaya Jasa</td>
                <td class="right">Rp {{ number_format($service->biaya_jasa, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="left bold">Total Bayar</td>
                <td class="right bold">Rp {{ number_format($service->total_bayar, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="dashed"></div>

        <div class="center">
            <p>Terima kasih telah menggunakan jasa kami</p>
            <p>~ Semoga selamat di jalan ~</p>
        </div>
    </div>
</body>
</html>
