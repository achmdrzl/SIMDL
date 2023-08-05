<!DOCTYPE html>
<html>

<head>
    <title>layout2</title>
    <style>
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
            margin-top: -25px;
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
        <table class="body" style="width: 100%">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Tanggal</td>
                    <td>Total Pengeluaran</td>
                    <td>Jenis Pengeluaran</td>
                    <td>Keterangan</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengeluaran as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->pengeluaran_tanggal }}</td>
                        <td>Rp. {{ number_format($item->pengeluaran_total) }}</td>
                        <td>{{ $item->pengeluaran_jenis }}</td>
                        <td>{{ $item->pengeluaran_keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: center;"><strong>Total</strong></td>
                    <td colspan="2" style="text-align: center;"><strong>Rp. {{ number_format($total) }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
