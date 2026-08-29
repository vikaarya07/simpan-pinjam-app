<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>
        Laporan Simpan Pinjam Bulan {{ $report['period']['label'] }} SATYA MUDA GETAS
    </title>

    <style>
        @page {
            margin: 30px 35px 40px 35px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }

        h1,
        h2,
        p {
            margin: 0;
            padding: 0;
        }

        h2 {
            font-size: 14px;
            line-height: 1.3;
            margin: 22px 0 5px;
            color: #0f172a;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .nowrap {
            white-space: nowrap;
        }

        .font-bold {
            font-weight: bold;
        }

        /* HEADER */
        .header {
            text-align: center;
            padding-bottom: 13px;
            border-bottom: 2px solid #0f172a;
            margin-bottom: 5px;
        }

        .header-title {
            font-size: 18px;
            line-height: 1.2;
            font-weight: bold;
            letter-spacing: 0.8px;
            color: #0f172a;
        }

        .header-period {
            margin-top: 5px;
            font-size: 14px;
            font-weight: bold;
            color: #1e1e1e;
        }

        /* SECTION */
        .table-section {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .section-title {
            page-break-after: avoid;
        }

        .section-description {
            margin-bottom: 8px;
            font-size: 9px;
            color: #64748b;
        }

        /* SUMMARY */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            page-break-inside: avoid;
        }

        .summary-table tr {
            page-break-inside: avoid;
        }

        .summary-table td {
            padding: 8px 9px;
            border: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .summary-label {
            width: 65%;
            color: #475569;
            font-weight: 500;
        }

        .summary-value {
            width: 35%;
            font-weight: bold;
        }

        .summary-total td {
            background: #F1F5F9;
            border-color: #CAD5E2;
            color: #314158;
            font-size: 11px;
            font-weight: bold;
        }

        /* DATA TABLE */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .data-table thead {
            display: table-header-group;
        }

        .data-table tbody {
            page-break-inside: avoid;
        }

        .data-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .data-table th {
            padding: 7px 6px;
            border: 1px solid #cbd5e1;
            background: #f1f5f9;
            color: #334155;
            font-size: 8.5px;
            font-weight: bold;
            text-align: left;
            vertical-align: middle;
        }

        .data-table td {
            padding: 6px;
            border: 1px solid #e2e8f0;
            color: #334155;
            vertical-align: middle;
        }

        .data-table tbody tr:nth-child(even) td {
            background: #fafafa;
        }

        .empty {
            padding: 15px !important;
            text-align: center;
            color: #94a3b8 !important;
            background: #f8fafc !important;
        }

        /* FOOTER */
        .footer {
            margin-top: 25px;
            padding-top: 8px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            color: #94a3b8;
            font-size: 8px;
        }
    </style>

</head>

<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="header-title">
            Laporan Simpan Pinjam Bulan
            {{ $report['period']['label'] }}
            SATYA MUDA GETAS
        </div>
    </div>

    {{-- DETAIL SUMMARY --}}
    <div class="table-section">

        <h2 class="section-title">
            Detail Ringkasan
        </h2>

        <div class="section-description">
            Seluruh nilai utama dalam laporan keuangan.
        </div>

        <table class="summary-table">
            <tbody>

                <tr>
                    <td class="summary-label">
                        Debit
                    </td>

                    <td class="summary-value text-right">
                        Rp {{ number_format($report['summary']['debit'] ?? 0, 0, ',', '.') }}
                    </td>
                </tr>

                <tr>
                    <td class="summary-label">
                        Credit
                    </td>

                    <td class="summary-value text-right ">
                        Rp {{ number_format($report['summary']['credit'] ?? 0, 0, ',', '.') }}
                    </td>
                </tr>

                <tr>
                    <td class="summary-label">
                        Saldo
                    </td>

                    <td class="summary-value text-right">
                        Rp {{ number_format($report['summary']['closing_balance'] ?? 0, 0, ',', '.') }}
                    </td>
                </tr>

                <tr>
                    <td class="summary-label">
                        Piutang
                    </td>

                    <td class="summary-value text-right">
                        Rp {{ number_format($report['summary']['closing_receivable'] ?? 0, 0, ',', '.') }}
                    </td>
                </tr>

                <tr class="summary-total">
                    <td>
                        Total Keseluruhan
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($report['summary']['closing_amount'] ?? 0, 0, ',', '.') }}
                    </td>
                </tr>

            </tbody>
        </table>

    </div>

    {{-- PINJAMAN --}}
    <div class="table-section">

        <h2 class="section-title">
            Pinjaman
        </h2>

        <div class="section-description">
            Daftar pinjaman yang tercatat pada periode ini.
            Total {{ $report['summary']['loan_count'] ?? 0 }} transaksi.
        </div>

        <table class="data-table">

            <thead>
                <tr>
                    <th class="text-center">No</th>

                    <th>Nasabah</th>

                    <th>Tanggal</th>

                    <th class="text-right">Pokok Pinjaman</th>

                    <th class="text-right">Jasa</th>

                    <th class="text-right">Total</th>

                    <th>Jenis</th>

                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($report['loans'] as $index => $loan)
                    <tr>

                        <td class="text-center">
                            {{ $index + 1 }}
                        </td>

                        <td>
                            {{ $loan->member?->name ?? '-' }}
                        </td>

                        <td>
                            {{ $loan->waktu ?? '-' }}
                        </td>

                        <td class="text-right nowrap">
                            Rp {{ number_format($loan->principal ?? 0, 0, ',', '.') }}
                        </td>

                        <td class="text-right nowrap">
                            Rp {{ number_format($loan->interest_amount ?? 0, 0, ',', '.') }}

                            @if ($loan->interest_percent !== null)
                                ({{ $loan->interest_percent }}%)
                            @endif
                        </td>

                        <td class="text-right nowrap font-bold">
                            Rp {{ number_format($loan->amount ?? 0, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ $loan->type?->label() ?? '-' }}
                        </td>

                        <td>
                            {{ $loan->status?->label() ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="empty">
                            Belum ada pinjaman pada periode ini.
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

    {{-- PEMBAYARAN ANGSURAN --}}
    <div class="table-section">

        <h2 class="section-title">
            Angsuran
        </h2>

        <div class="section-description">
            Riwayat pembayaran angsuran pada periode ini.
            Total {{ $report['summary']['payment_count'] ?? 0 }} transaksi.
        </div>

        <table class="data-table">

            <thead>
                <tr>

                    <th class="text-center">No</th>

                    <th>Nasabah</th>

                    <th>Tanggal</th>

                    <th>Meeting</th>

                    <th class="text-right">Nominal</th>

                    <th>Metode</th>

                </tr>
            </thead>

            <tbody>

                @forelse ($report['payments'] as $index => $payment)
                    <tr>

                        <td class="text-center">
                            {{ $index + 1 }}
                        </td>

                        <td>
                            {{ $payment->loan?->member?->name ?? '-' }}
                        </td>

                        <td>
                            {{ $payment->waktu ?? '-' }}
                        </td>

                        <td>
                            {{ $payment->meeting?->place ?? '-' }}
                        </td>

                        <td class="text-right nowrap font-bold">
                            Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ $payment->method?->label() ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="empty">
                            Belum ada pembayaran pada periode ini.
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

    {{-- SAVING --}}
    <div class="table-section">

        <h2 class="section-title">
            Simpanan / Kas
        </h2>

        <div class="section-description">
            Daftar transaksi kas yang tercatat pada periode ini.
        </div>

        <table class="data-table">

            <thead>
                <tr>

                    <th class="text-center">
                        No
                    </th>

                    <th>
                        Tanggal
                    </th>

                    <th>
                        Jenis
                    </th>

                    <th class="text-right">
                        Debit
                    </th>

                    <th class="text-right">
                        Credit
                    </th>

                    <th class="text-right">
                        Saldo
                    </th>

                    <th class="text-right">
                        Piutang
                    </th>

                    <th class="text-right">
                        Total
                    </th>

                </tr>
            </thead>

            <tbody>

                @forelse ($report['savings'] as $index => $saving)
                    <tr>

                        <td class="text-center">
                            {{ $index + 1 }}
                        </td>

                        <td>
                            {{ $saving->waktu ?? '-' }}
                        </td>

                        <td>
                            {{ $saving->type?->label() ?? '-' }}
                        </td>

                        <td class="text-right nowrap">
                            Rp {{ number_format($saving->debit ?? 0, 0, ',', '.') }}
                        </td>

                        <td class="text-right nowrap">
                            Rp {{ number_format($saving->credit ?? 0, 0, ',', '.') }}
                        </td>

                        <td class="text-right nowrap">
                            Rp {{ number_format($saving->balance ?? 0, 0, ',', '.') }}
                        </td>

                        <td class="text-right nowrap">
                            Rp {{ number_format($saving->receivable ?? 0, 0, ',', '.') }}
                        </td>

                        <td class="text-right nowrap font-bold">
                            Rp {{ number_format($saving->amount ?? 0, 0, ',', '.') }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="empty">
                            Tidak ada transaksi kas pada periode ini.
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

    {{-- FOOTER --}}
    <div class="footer">
        Laporan Bulanan &mdash; {{ $report['period']['label'] }}
    </div>

</body>

</html>
