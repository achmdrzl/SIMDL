<!DOCTYPE html>
<html>

<head>
    <title>Manifest - Den Logistik</title>
    <style>
        body {
            font-family: "Calibri", sans-serif;
            font-size: 12px;
        }

        .row {
            display: flex;
            align-items: center;
        }

        .header2 {
            max-width: 600px;
            margin-left:10px;
        }

        .table-container {
            flex: 1;
            float: right;
        }

        table.body {
            margin-top: -25px;
            margin-left:10px;
            border-collapse: collapse;
        }

        table.body thead {
            background-color: greenyellow;
            font-weight: bold;
        }

        .manifest {
            background-color: yellow;
            border: 1px solid black;
        }

        table.body,
        table.body th,
        table.body td {
            border: 1px solid black;
            padding: 2px;
        }

        th,
        td {
            padding: 2px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="row">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/backend/denlogistik/layout2_header.png'))) }}"
            alt="Gambar" class="header2" />
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th class="manifest">{{ $manifest->manifest_plat_mobil }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>No Manifest</td>
                        <td class="manifest">{{ $manifest->manifest_no }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td class="manifest">{{ date('d-M-Y', strtotime($manifest->manifest_tanggal)) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <br>
    <div class="body">
        <table class="body" style="width: 100%">
            <thead>
                <tr>
                    <td>No</td>
                    <td>No Resi</td>
                    <td>Penerima</td>
                    <td>Koli</td>
                    <td>Rincian</td>
                    <td>Berat</td>
                    <td>Volume</td>
                    <td>Isi Barang</td>
                    <td>Metode Pembayaran</td>
                    <td>Keterangan</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($manifest->detailmanifest as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->order->order_noresi }}</td>
                        <td>{{ $item->order->order_penerima }}</td>
                        <td>{{ $item->order->order_koli }}</td>
                        <td>{{ $item->order->order_rincian }}</td>
                        <td>{{ $item->order->order_berat }}</td>
                        <td>{{ $item->order->order_volume }}</td>
                        <td>{{ $item->order->order_isi }}</td>
                        <td>{{ ucfirst($item->order->payment->payment_method) }}</td>
                        {{-- <td>{{ $item->order->payment->payment_keterangan == null ? '-' : ucfirst($item->order->payment->payment_keterangan) }} --}}
                        <td>{{ $item->ket == null ? '-' : ucfirst($item->ket) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: center;"><strong>Total</strong></td>
                    <td><strong>{{ $manifest->manifest_total_koli }}</strong></td>
                    <td></td>
                    <td colspan="2" style="text-align: center;">
                        <strong>{{ $manifest->manifest_total_berat + $manifest->manifest_total_volume }}</strong></td>
                    <td><strong>Kg</strong></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
