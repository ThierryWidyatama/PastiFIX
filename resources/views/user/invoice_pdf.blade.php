<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $invoice_no }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; color: #333; }
        .header { width: 100%; border-bottom: 2px solid #FEC81A; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #000; }
        .logo span { color: #FEC81A; }
        
        .invoice-details { width: 100%; margin-bottom: 30px; }
        .invoice-details td { vertical-align: top; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        .table-items { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table-items th { background-color: #f8f9fa; padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        .table-items td { padding: 10px; border-bottom: 1px solid #eee; }
        
        .total-section { width: 100%; margin-top: 20px; }
        .grand-total { font-size: 18px; font-weight: bold; color: #FEC81A; }
        
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #777; border-top: 1px solid #eee; padding-top: 20px; }
        
        /* Status Lunas Stamp */
        .stamp-paid {
            border: 2px solid #50cd89;
            color: #50cd89;
            font-size: 20px;
            font-weight: bold;
            padding: 5px 15px;
            display: inline-block;
            transform: rotate(-10deg);
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <table class="header">
        <tr>
            <td>
                <div class="logo">Pasti<span>FIX</span></div>
                <div>Solusi Renovasi Terpercaya</div>
            </td>
            <td class="text-right">
                <h2 style="margin: 0;">INVOICE</h2>
                <div class="stamp-paid">LUNAS</div>
            </td>
        </tr>
    </table>

    <!-- INFO PENGIRIM & PENERIMA -->
    <table class="invoice-details">
        <tr>
            <td width="50%">
                <strong>Diterbitkan Oleh:</strong><br>
                PT. PastiFIX Indonesia<br>
                Jl. Pemuda No. 123, Semarang<br>
                support@pastifix.com
            </td>
            <td width="50%" class="text-right">
                <strong>Kepada Yth:</strong><br>
                {{ $user->name }}<br>
                {{ $order->projectAddress->address_line ?? 'Alamat tidak tersedia (Terhapus)' }}<br>
                {{ $order->projectAddress->postal_code ?? '-' }}
            </td>
        </tr>
    </table>

    <!-- DETAIL PESANAN -->
    <div style="margin-bottom: 20px;">
        <strong>Nomor Invoice:</strong> {{ $invoice_no }}<br>
        <strong>Tanggal Cetak:</strong> {{ $date }}<br>
        <strong>Layanan:</strong> {{ $order->category->name }}
    </div>

    <!-- TABEL ITEM -->
    <table class="table-items">
        <thead>
            <tr>
                <th>Deskripsi Item / Jasa</th>
                <th class="text-right">Harga (IDR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->costItems as $item)
            <tr>
                <td>{{ $item->item_name }}</td>
                <td class="text-right">{{ number_format($item->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTAL -->
    <table class="total-section">
        <tr>
            <td width="70%"></td>
            <td width="30%">
                <table width="100%">
                    <tr>
                        <td class="text-right font-bold">Total Tagihan:</td>
                        <td class="text-right grand-total">Rp {{ number_format($order->estimated_cost, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        Terima kasih telah menggunakan jasa PastiFIX.<br>
        Bukti pembayaran ini sah dan diterbitkan secara komputerisasi.
    </div>

</body>
</html>