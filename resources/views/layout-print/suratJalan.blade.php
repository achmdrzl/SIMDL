<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Surat Jalan - Den Logistik</title>

    <style>
      body {
        font-family: "Arial", Times, serif;
        font-size: 12px;
      }
      h1,
      h2,
      h3,
      h4,
      h5,
      h6 {
        font-size: initial;
      }
      .noreg {
        float: right;
        margin-top: 20px;
        margin-right: 40px;
        margin-bottom: 80px;
        margin-bottom: 30px;
      }
      table.product {
        width: 100%;
        margin-top: 10px;
        text-align: right;
      }
      .dos {
        margin-top: 10px;
        margin-bottom: 20px;
        margin-left: 150px;
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
       .table-2{
        margin-top: 10px;
      }
      th,
      td {
        /* border: 1px solid black;   */
        padding: 8px;
        text-align: left; /* Align content to the right */
      }

      .tujuan{
        margin-top: 120px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="noreg">
        <h3>{{ $order->order_noresi }}</h3>
      </div>
      <div class="tujuan">
        <table>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ ucfirst($order->order_pengirim) }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td style="margin-left: 20px;">{{ ucfirst($order->order_penerima) }}</td>
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
            <td style="margin-left: 20px;">
              {{ ucfirst($order->order_alamat_penerima) }} <br />
             {{ $order->order_nohp_penerima }}
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </table>
        <div class="dos">dos</div>
        <div class="table-2">
          <table class="product">
            <tr>
              <td style="text-align: left">{{ $order->order_koli }}</td>
              <td></td>
              <td>{{ $order->order_berat }}</td>
              <td style="text-align: right">{{ $order->order_volume }}</td>
              <td></td>
              <td></td>
              <td></td>
              <td style="text-align: left">{{ $order->order_isi }}</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td style="text-align: left">{{ $order->order_tarif }}</td>
              <td></td>
              <td style="text-align: center">{{ $order->order_lampiran }}<br>{{ $order->order_pengirim }}</td>
            </tr>
          </table>
          <div class="row">
            <!-- <div class="hitungan">
              7, 31x16x15=2x15=30, 42x30x15=5,<br />48x35x11=5, 38x15x23=3
            </div> -->
            <div class="total">
              <table>
                <tr>
                  <td>{{ $order->order_rincian }}</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: center"></td>
                  <td style="text-align: left"></td>
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
                  <td style="text-align: center"><strong>Rp</strong></td>
                  <td style="text-align: left"><strong>{{ number_format($order->order_total) }}</strong></td>
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
                  <td style="text-align: left">{{ $order->order_keterangan }}</td>
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
                  <td style="text-align: right">
                    <strong>{{ date("d-M-Y", strtotime($order->order_tanggal)) }}</strong>
                  </td>
                  <td></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
