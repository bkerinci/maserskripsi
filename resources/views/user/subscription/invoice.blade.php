<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $transaction->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.4;
            padding: 30px;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .header-table td {
            vertical-align: top;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #1e40af;
        }
        .invoice-details {
            text-align: right;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .info-table td {
            width: 50%;
            vertical-align: top;
        }
        .title {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .value {
            font-size: 15px;
            font-weight: bold;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .items-table th {
            background-color: #f3f4f6;
            border-bottom: 2px solid #e5e7eb;
            text-align: left;
            padding: 12px;
            font-size: 11px;
            text-transform: uppercase;
            color: #4b5563;
        }
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }
        .items-table .total-row td {
            border-bottom: none;
            font-weight: bold;
            font-size: 15px;
            padding-top: 20px;
        }
        .footer {
            text-align: center;
            font-size: 11px;
            color: #9ca3af;
            margin-top: 50px;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table class="header-table">
            <tr>
                <td>
                    <div class="logo">MasterSkripsi</div>
                    <div style="font-size: 11px; color: #666; margin-top: 5px;">
                        Layanan Pendamping Skripsi Berbasis AI
                    </div>
                </td>
                <td class="invoice-details">
                    <h2 style="margin: 0; color: #111827;">INVOICE</h2>
                    <div style="font-size: 13px; color: #4b5563; margin-top: 5px;">
                        No: #{{ $transaction->id }}<br>
                        Tanggal: {{ $transaction->created_at->format('d M Y H:i') }}
                    </div>
                </td>
            </tr>
        </table>

        <table class="info-table">
            <tr>
                <td>
                    <div class="title">Diterbitkan Kepada:</div>
                    <div class="value">{{ $transaction->user->name ?? 'Pelanggan' }}</div>
                    <div style="font-size: 13px; color: #4b5563; margin-top: 3px;">
                        Email: {{ $transaction->user->email ?? '-' }}
                    </div>
                </td>
                <td>
                    <div class="title">Detail Pembayaran:</div>
                    <div class="value">
                        Status: <span style="color: #16a34a;">LUNAS</span>
                    </div>
                    <div style="font-size: 13px; color: #4b5563; margin-top: 3px;">
                        Metode: {{ $transaction->payment_method ? strtoupper($transaction->payment_method) : 'Online Payment' }}
                    </div>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Deskripsi Layanan</th>
                    <th style="text-align: right; width: 100px;">Durasi</th>
                    <th style="text-align: right; width: 150px;">Harga</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>Paket {{ $transaction->subscriptionPlan->name ?? 'Premium Plan' }}</strong><br>
                        <span style="font-size: 11px; color: #6b7280;">Akses penuh ke semua fitur premium MasterSkripsi</span>
                    </td>
                    <td style="text-align: right; vertical-align: top;">
                        {{ $transaction->subscriptionPlan->duration_days ?? 30 }} Hari
                    </td>
                    <td style="text-align: right; vertical-align: top;">
                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </td>
                </tr>
                <tr class="total-row">
                    <td></td>
                    <td style="text-align: right;">Total Bayar:</td>
                    <td style="text-align: right; color: #1e40af;">
                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            Terima kasih atas kepercayaan Anda menggunakan MasterSkripsi.<br>
            Jika ada pertanyaan mengenai tagihan ini, silakan hubungi cs@masterskripsi.my.id.
        </div>
    </div>
</body>
</html>
