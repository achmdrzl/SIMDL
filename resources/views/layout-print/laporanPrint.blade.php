<!DOCTYPE html>
<html>

<head>
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-size: 14px;
            font-family: "Calibri", sans-serif;
        }

        .row {
            display: flex;
            align-items: center;
        }

        .header2 {
            max-width: 700px;
        }

        .table-container {
            flex: 1;
            float: right;
        }

        table.body {
            margin-top: 25px;
            border-collapse: collapse;
        }

        table.body thead {
            background-color: greenyellow;
        }

        .manifest {
            background-color: yellow;
            border: 1px solid black;
        }

        table.body,
        table.body th,
        table.body td {
            border: 1px solid black;
            padding: 4px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="row">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/backend/denlogistik/layout2_header.png'))) }}"
            alt="Gambar" class="header2" />
        <br>
        <br>
        <div class="body">
            <h3 style="position: absolute;">Laporan Keuangan</h3>&nbsp;
            <h3 style="float:right; position: flex;">Tanggal : {{ $laporan->laporan_tanggal }}</h3>&nbsp;
            <table class="body" style="width: 100%">
                <tr style="background-color: rosybrown;">
                    <th colspan="3">Pendapatan Omset :</th>
                    <th style="text-align: right;">Rp. {{ number_format($order_sum) }}</th>
                </tr>
                <tr style="background-color: rosybrown;">
                    <th colspan="3">Pendapatan Handling :</th>
                    <th style="text-align: right;">Rp. {{ number_format($laporan->laporan_total_handling) }}</th>
                </tr>
                <tr>
                    <th colspan="4"></th>
                </tr>
                <tr style="background-color: rosybrown; text-align:center;">
                    <th style="text-align: center;">Kota</th>
                    <th style="text-align: center;">Tarif</th>
                    <th style="text-align: center;">Berat</th>
                    <th style="text-align: center;">Total</th>
                </tr>
                @foreach ($laporan->handling as $item)
                    <tr>
                        <td style="text-align: center;">{{ $item->handling_kota }}</td>
                        <td style="text-align: right;">Rp. {{ number_format($item->handling_tarif) }}</td>
                        <td style="text-align: center;">{{ $item->handling_berat }} Kg</td>
                        <td style="text-align: right;">Rp. {{ number_format($item->handling_total) }}</td>
                    </tr>
                @endforeach
                <tr style="background-color: greenyellow;">
                    <th colspan="3" style="text-align: center;">Total Pendapatan</th>
                    <th style="text-align: right;">Rp.
                        {{ number_format($order_sum + $laporan->laporan_total_handling) }}</th>
                </tr>
                <tr>
                    <th colspan="4" style="background-color: rosybrown;">Beban-beban</th>
                </tr>
                <tr>
                    <th colspan="4"></th>
                </tr>
                <tr>
                    <td></td>
                    <th colspan="2" style="background-color: rosybrown;">Beban Operasional Kantor :</th>
                    <td></td>
                </tr>
                @foreach ($laporan->operasional as $item)
                    <tr>
                        <td></td>
                        <td colspan="2">{{ $item->operasional_keterangan }}</td>
                        <td style="text-align: right;">Rp. {{ number_format($item->operasional_total) }}</td>
                    </tr>
                @endforeach
                <tr style="background-color: greenyellow;">
                    <td></td>
                    <th colspan="2">Total Beban Operasional Kantor :</th>
                    <th style="text-align: right;">Rp. {{ number_format($laporan->laporan_total_operasional) }}</th>
                </tr>
                <tr>
                    <th colspan="4"></th>
                </tr>
                <tr>
                    <td></td>
                    <th colspan="2" style="background-color: rosybrown;">Beban Transportasi :</th>
                    <td></td>
                </tr>
                @foreach ($laporan->transportasi as $item)
                    <tr>
                        <td></td>
                        <td colspan="2">{{ $item->transportasi_keterangan }}</td>
                        <td style="text-align: right;">Rp. {{ number_format($item->transportasi_total) }}</td>
                    </tr>
                @endforeach
                <tr style="background-color: greenyellow;">
                    <td></td>
                    <th colspan="2">Total Beban Operasional Kantor :</th>
                    <th style="text-align: right;">Rp. {{ number_format($laporan->laporan_total_transportasi) }}</th>
                </tr>
                <tr>
                    <th colspan="4"></th>
                </tr>
                <tr>
                    <td></td>
                    <th colspan="2" style="background-color: rosybrown;">Beban Gaji Karyawan :</th>
                    <td></td>
                </tr>
                @foreach ($laporan->gaji as $item)
                    <tr>
                        <td></td>
                        <td colspan="2">{{ $item->gaji_keterangan }}</td>
                        <td style="text-align: right;">Rp. {{ number_format($item->gaji_total) }}</td>
                    </tr>
                @endforeach
                <tr style="background-color: greenyellow;">
                    <td></td>
                    <th colspan="2">Total Beban Gaji Karyawan :</th>
                    <th style="text-align: right;">Rp. {{ number_format($laporan->laporan_total_gaji) }}</th>
                </tr>
                <tr>
                    <th colspan="4"></th>
                </tr>
                 <tr style="background-color: greenyellow;">
                    <td></td>
                    <th colspan="2">Total Pengeluaran Makassar :</th>
                    <th style="text-align: right;">Rp. {{ number_format($laporan->laporan_total_pengeluaran_mks) }}</th>
                </tr>
                <tr>
                    <th colspan="4"></th>
                </tr>
                <tr style="background-color: greenyellow;">
                    <th colspan="3" style="text-align: center;">Total Laba Bersih :</th>
                    <th style="text-align: right;">Rp.
                        {{ number_format($laba_bersih) }}
                    </th>
                </tr>
            </table>
        </div>
</body>

</html>
