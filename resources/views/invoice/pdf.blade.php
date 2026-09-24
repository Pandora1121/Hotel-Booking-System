<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $booking->booking_code }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #1a1a1a; }
        .header { border-bottom: 3px solid #12202B; padding-bottom: 16px; margin-bottom: 24px; overflow: hidden; }
        .brand { font-size: 20px; font-weight: bold; color: #12202B; float: left; }
        .brand span { color: #C9A227; }
        .invoice-title { float: right; text-align: right; }
        .invoice-title h2 { margin: 0; font-size: 16px; color: #12202B; }
        .invoice-title p { margin: 2px 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.info td { padding: 4px 0; vertical-align: top; }
        table.info td.label { color: #888; width: 130px; }
        table.detail { margin-top: 20px; }
        table.detail th { background: #12202B; color: #fff; text-align: left; padding: 10px; font-size: 11px; }
        table.detail td { padding: 10px; border-bottom: 1px solid #eee; }
        .text-right { text-align: right; }
        .total-row td { font-weight: bold; font-size: 14px; border-top: 2px solid #12202B; }
        .status-badge {
            display: inline-block; padding: 4px 12px; border-radius: 12px;
            font-size: 11px; font-weight: bold; background: #FEF3C7; color: #92400E;
        }
        .footer { margin-top: 40px; padding-top: 16px; border-top: 1px solid #eee; color: #999; font-size: 10px; text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <div class="brand">Kirana <span>Hotel &amp; Resort</span></div>
        <div class="invoice-title">
            <h2>INVOICE</h2>
            <p>{{ $booking->payment->invoice_number ?? '-' }}</p>
        </div>
    </div>

    <table class="info">
        <tr>
            <td class="label">Kode Booking</td>
            <td>: {{ $booking->booking_code }}</td>
            <td class="label">Status</td>
            <td>: <span class="status-badge">{{ strtoupper($booking->status) }}</span></td>
        </tr>
        <tr>
            <td class="label">Nama Tamu</td>
            <td>: {{ $booking->user->name }}</td>
            <td class="label">Tanggal Booking</td>
            <td>: {{ $booking->created_at->translatedFormat('j M Y') }}</td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td>: {{ $booking->user->email }}</td>
            <td class="label">No. WhatsApp</td>
            <td>: {{ $booking->user->phone ?? '-' }}</td>
        </tr>
    </table>

    <table class="detail">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th class="text-right">Malam</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {{ $booking->room->hotel->name }}<br>
                    <span style="color:#888;">{{ $booking->room->roomType->name }} — Kamar {{ $booking->room->room_number }}</span>
                </td>
                <td>{{ $booking->check_in->translatedFormat('j M Y') }}</td>
                <td>{{ $booking->check_out->translatedFormat('j M Y') }}</td>
                <td class="text-right">{{ $booking->total_nights }}</td>
                <td class="text-right">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL</td>
                <td class="text-right">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    @if ($booking->notes)
        <p><strong>Catatan:</strong> {{ $booking->notes }}</p>
    @endif

    <div class="footer">
        Invoice ini dibuat otomatis oleh sistem Kirana Hotel &amp; Resort pada {{ now()->translatedFormat('j M Y, H:i') }} WIB.<br>
        Terima kasih telah memesan bersama kami.
    </div>

</body>
</html>