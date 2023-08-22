<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<head>
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-size: 12px;
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
            margin-top: 75px;
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
            <h3 style="position: absolute; left: 50%; transform: translateX(-50%); margin-top: 0;">FORM PENGELUARAN
                MINGGUAN</h3>
            <h3 style="position: absolute; left: 50%; transform: translateX(-50%); margin-top: 20px;">DEN LOGISTIK
                MAKASSAR</h3>

            <h4 style="position: absolute; left: 70%; transform: translateX(-50%); margin-top: 60px;">Minggu ke .....
                Bulan ............</h4>
            <table class="body" style="width: 100%">
                <tr style="text-align: center;">
                    <th style="text-align: center;">No</th>
                    <th style="text-align: center;">Hari/Tgl</th>
                    <th style="text-align: center;">Modal</th>
                    <th style="text-align: center;">Pengeluaran</th>
                    <th style="text-align: center;">Keterangan</th>
                </tr>
                @foreach ($data[0]['pengeluaran'] as $item)
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        @php
                            $englishDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                            $indonesianDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                            $dayIndex = date('w', strtotime($item->pengeluaran_tanggal));
                            $indonesianDay = $indonesianDays[$dayIndex];
                        @endphp
                        <td style="text-align: center;">{{ ucfirst($indonesianDay) }}, {{ $item->pengeluaran_tanggal }}
                        </td>
                        <td>
                            @foreach ($item->modal as $modalData)
                                @if ($modalData->modal_total != null)
                                    <div style="text-align: center;">Rp {{ number_format($modalData->modal_total) }}
                                    </div>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($item->operasional as $operasionalData)
                                @if ($operasionalData->operasional_total != null)
                                    <div style="text-align: center;">Rp {{ number_format($operasionalData->operasional_total) }}</div>
                                @endif
                            @endforeach
                            @foreach ($item->transportasi as $transportasiData)
                                @if ($transportasiData->transportasi_total != null)
                                    <div style="text-align: center;">Rp {{ number_format($transportasiData->transportasi_total) }}</div>
                                @endif
                            @endforeach
                            @foreach ($item->gaji as $gajiData)
                                @if($gajiData->gaji_total != null)
                                    <div style="text-align: center;">Rp {{ number_format($gajiData->gaji_total) }}</div>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($item->operasional as $operasionalData)
                                @if ($operasionalData->operasional_keterangan != null)
                                     <div style="text-align: left;">
                                        {{ ucfirst($operasionalData->operasional_keterangan) }}
                                    </div>
                                @endif
                            @endforeach
                            @foreach ($item->transportasi as $transportasiData)
                                @if ($transportasiData->transportasi_keterangan != null)
                                    <div style="text-align: left;">
                                        {{ ucfirst($transportasiData->transportasi_keterangan) }}
                                    </div>
                                @endif     
                            @endforeach
                            @foreach ($item->gaji as $gajiData)
                                @if($gajiData->gaji_keterangan != null)
                                    <div style="text-align: left;">
                                        {{ ucfirst($gajiData->gaji_keterangan) }}
                                    </div>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="2" style="text-align: center;">Saldo</th>
                    <th style="text-align: center;">Rp {{ number_format($data[0]['total_modal']) }}</th>
                    <th colspan="2" style="text-align: center;">Rp {{ number_format($data[0]['total'] - $data[0]['total_modal']) }}</th>
                </tr>
                <tr>
                    <th colspan="2" style="text-align: center;">Total Pengeluaran</th>
                    <th style="text-align: center;" colspan="3">Rp {{ number_format($data[0]['total']) }}</th>
                </tr>
            </table>
        </div>
</body>

</html>
