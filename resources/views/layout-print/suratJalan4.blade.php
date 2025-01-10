<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Surat Jalan - Den Logistik</title>

    <style>
        body {
            /*font-family: "Calibri", sans-serif;*/
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-size: 25px;
        }

        .noreg {
            float: right;
            margin-top: 10px;
            margin-right: -20px;
            margin-bottom: 110px;
        }

        table.product {
            width: 100%;
            margin-top: 20px;
            text-align: right;
        }

        .dos {
            margin-bottom: 10px;
            margin-left: 120px;
        }

        .product {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .row {
            display: flex;
        }

        .total {
            flex: 1;
        }

        .padded-row div {
            padding-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-2 {
            margin-top: -5px;
        }

        th,
        td {
            /*border: 1px solid black;*/
            padding: 7px;
            /* font-weight: 350; */
            text-align: left;
            /* Align content to the right */
        }

        .tujuan {
            margin-top: 95px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="noreg">
            <h1>{{ $order->order_noresi }}</h1>
        </div>
        <div class="tujuan">
            <table>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="margin-left: 20px"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="font-size: 15px">{{ $order->order_pengirim }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="margin-left: 10px; font-size: 14px">
                        <div style="font-size: 15px">
                            {{ $order->order_penerima }}
                        </div>
                        {{ $order->order_alamat_penerima }} <br />
                        {{ $order->order_nohp_penerima }}
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: left; padding-left: 40px;">
                        {{ $order->order_kemasan }}
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <div class="dos"></div>
            <div class="table-2">
                <table class="product">
                    <tr>
                      <td style="text-align: left;">
                          <div style="margin-left:-20px;">
                              {{ $order->order_koli }}
                          </div>
                      </td>
                        <td></td>
                        <td style="text-align: center">{{ $order->order_berat }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: left">{{ $order->order_volume }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: center">{{ $order->order_isi }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right">
                            <div style="margin-left: 40px">
                                {{ number_format($order->order_tarif) }}
                            </div>
                        </td>
                        <td>
                            <div style="text-align: right">
                                {{ $order->order_lampiran }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right">
                          <div style="margin-top:10px;">
                            Rp {{ number_format($order->order_total) }}
                          </div>
                        </td>
                    </tr>
                </table>
                <div class="row">
                    <!-- <div class="hitungan">
              7, 31x16x15=2x15=30, 42x30x15=5,<br />48x35x11=5, 38x15x23=3
            </div> -->
                    <div class="total">
                        <table>
                            <tr>
                                <td style="font-size: 13px">{{ $order->order_rincian }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="text-align: right">
                                    {{ $order->order_keterangan }}
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="text-align: right">
                                    {{ date('d-M-Y', strtotime($order->order_tanggal)) }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
