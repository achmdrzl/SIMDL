<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\InputHistory;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\User;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PDO;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    // INDEX ORDER
    public function orderIndex(Request $request)
    {
        $orders = Order::with(['payment.userAcc', 'userCreate'])->get();

        if ($request->ajax()) {
            $orders = Order::with(['payment'])
            ->orderBy('updated_at', 'desc') // Order by the 'updated_at' column in descending order
            ->get();
            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('order_noresi', function ($item) {
                    return $item->order_noresi;
                })
                // ->addColumn('order_tanggal', function ($item) {
                //     return $item->order_tanggal;
                // })
                ->addColumn('order_pengirim', function ($item) {
                    return ucfirst($item->order_pengirim);
                })
                ->addColumn('order_penerima', function ($item) {
                    return ucfirst($item->order_penerima);
                })
                // ->addColumn('order_berat', function ($item) {
                //     return $item->order_berat . 'Kg';
                // })
                // ->addColumn('order_volume', function ($item) {
                //     return $item->order_volume;
                // })
                // ->addColumn('order_tarif', function ($item) {
                //     return 'Rp.' . number_format($item->order_tarif);
                // })
                // ->addColumn('order_total', function ($item) {
                //     return 'Rp. ' . number_format($item->order_total);
                // })
                ->addColumn('payment_status', function ($item) {
                    if ($item->payment->payment_status == 'lunas') {
                        $status = '<div class="badge bg-success">' . strtoupper($item->payment->payment_status) . '</div>';
                    } else {
                        $status = '<div class="badge bg-danger">' . strtoupper($item->payment->payment_status) . '</div>';
                    }
                    return $status;
                })
                ->addColumn('payment_method', function ($item) {
                    if($item->payment->payment_method === 'bayar-makassar'){
                        $method = 'byr-mks';
                    }else if($item->payment->payment_method === 'bayar-surabaya'){
                        $method = 'byr-sby';
                    }else{
                        $method = 'cash';
                    }
                    return $item->payment->payment_method == null ? '-' : strtoupper($method);
                })
                ->addColumn('order_status', function ($item) {
                    if ($item->order_status == 'terdaftar') {
                        $status = '<div class="badge bg-secondary">' . strtoupper($item->order_status) . '</div>';
                    } elseif ($item->order_status == 'on-progress') {
                        $status = '<div class="badge bg-warning">' . strtoupper($item->order_status) . '</div>';
                    } else {
                        $status = '<div class="badge bg-success">' . strtoupper($item->order_status) . '</div>';
                    }
                    return $status;
                })
                // ->addColumn('order_create', function ($item) {
                //     $name = $item->userCreate->name == null ? '-' : ucfirst($item->userCreate->name);
                //     $city = $item->userCreate->city == null ? '-' : ucfirst($item->userCreate->city);

                //     if($city)

                //     return ucfirst($name) . ' - ' . ucfirst($city);
                // })
                // ->addColumn('order_received_validation', function ($item) {
                //     $userReceived = optional($item->userReceive);

                //     // Check if the 'userReceived' relationship exists and if it has the 'name' property
                //     $name = optional($userReceived)->name;
                //     $city = optional($userReceived)->city;

                //     // Use a default value ('-') if the 'name' is null
                //     // $data[] = $name === null ? '-' : ucfirst($name);
                //     $name === null ? '-' : ucfirst($name);
                //     $city === null ? '-' : ucfirst($city);

                //     return ucfirst($name) . ' - ' . ucfirst($city);
                // })
                ->addColumn('order_received', function ($item) {
                    $order_received = $item->order_received == null ? '-' : ucfirst($item->order_received);

                    return $order_received;
                })
                ->addColumn('payment_acc', function ($item) {
                    $userAcc = optional($item->payment)->userAcc;

                    // Check if the 'userAcc' relationship exists and if it has the 'name' property
                    $name = optional($userAcc)->name;
                    $city = optional($userAcc)->city;

                    // Use a default value ('-') if the 'name' is null
                    // $data[] = $name === null ? '-' : ucfirst($name);
                    $name === null ? '-' : ucfirst($name);
                    $city === null ? '-' : ucfirst($city);
                    if ($name != null) {
                        if ($city == 'surabaya') {
                            $kota = 'sby';
                        } else if ($city = 'makassar') {
                            $kota = 'mks';
                        } else {
                            $kota = '';
                        }
                    } else {
                        $kota = '';
                    }
                    return ucfirst($name) . ' - ' . ucfirst($kota);
                })
                ->addColumn('action', function ($item) {
                    $btn = '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="order-print" title="PRINT SURAT JALAN" data-id="' . $item->order_id . '"><span class="material-icons btn-sm">print</span></button>';

                    $btn = $btn . '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="order-receive" title="TERIMA ORDER" data-id="' . $item->order_id . '"><span class="material-icons btn-sm">check_box</span></button>';

                    // $btn = $btn . '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="order-edit" title="EDIT ORDER" data-id="' . $item->order_id . '"><span class="material-icons btn-sm">edit</span></button>';

                    $btn = $btn . '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="btn-detail" title="DETAIL ORDER" data-id="' . $item->order_id . '"><span class="material-icons btn-sm">visibility</span></button>';

                    return $btn;
                })
                ->rawColumns(['payment_status', 'order_status', 'action'])
                ->make(true);
        }

        return view('transaksi.data-order', compact('orders'));
    }

    // STORED DATA ORDER
    public function orderStore(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'order_tanggal'         => 'required',
            'order_pengirim'        => 'required',
            'order_penerima'        => 'required',
            'order_alamat_penerima' => 'required',
            'order_nohp_penerima'   => 'required',
            'order_koli'            => 'required',
            'order_kemasan'         => 'required',
            'order_rincian'         => 'required',
            'order_berat'           => 'required',
            'order_volume'          => 'required',
            'order_isi'             => 'required',
            'order_tarif'           => 'required',
            'direct'                => 'nullable',
            'payment_bukti'         => 'required_if:direct,1|mimes:jpeg,jpg,png,pdf|max:5048',
        ], [
            'order_tanggal.required'         => 'Tanggal Order Harus di Isi!',
            'order_pengirim.required'        => 'Pengirim Harus di Isi!',
            'order_penerima.required'        => 'Penerima Harus di Isi!',
            'order_alamat_penerima.required' => 'Alamat Penerima Harus di Isi!',
            'order_nohp_penerima.required'   => 'No Hp Penerima Harus di Isi!',
            'order_koli.required'            => 'Koli Harus di Isi!',
            'order_rincian.required'         => 'Rincian Harus di Isi!',
            'order_berat.required'           => 'Berat Harus di Isi!',
            'order_volume.required'          => 'Volume Harus di Isi!',
            'order_isi.required'             => 'Barang Isi Harus di Isi!',
            'order_kemasan.required'         => 'Kemasan Harus di Isi!',
            'order_tarif.required'           => 'Tarif Harus di Isi!',
            'payment_bukti.required_if'      => 'Bukti Pembayaran Harus di Upload!'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // Define the model name
        $modelName = 'DataOrder';

        // Get the current date and time
        $currentTime = Carbon::createFromFormat('Y-m-d', $request->order_tanggal);

        // Get the formatted date portion (yymmdd)
        $datePart = $currentTime->format('y');

        // Get the current counter value from cache for the specific model
        $counter = Cache::get($modelName . '_counter');

        // Increment the counter
        $counter++;

        // Check if the counter reaches 9999, then reset it
        if ($counter > 9999) {
            $counter = 1;
        }

        // Store the updated counter in the cache
        Cache::put($modelName . '_counter', $counter);

        // Generate the new ID
        $newId = $datePart . sprintf("%04d", $counter);

        // Stored new Data Order
        $order  = Order::updateOrCreate([
            'order_id'              => $request->order_id,
        ], [
            'order_noresi'          => $newId,
            'order_tanggal'         => $request->order_tanggal,
            'order_pengirim'        => $request->order_pengirim,
            'order_penerima'        => $request->order_penerima,
            'order_alamat_penerima' => $request->order_alamat_penerima,
            'order_nohp_penerima'   => $request->order_nohp_penerima,
            'order_koli'            => $request->order_koli,
            'order_kemasan'         => $request->order_kemasan,
            'order_rincian'         => $request->order_rincian,
            'order_berat'           => $request->order_berat,
            'order_volume'          => $request->order_volume,
            'order_isi'             => $request->order_isi,
            'order_tarif'           => $request->order_tarif,
            'order_total'           => $request->order_total,
            'order_lampiran'        => $request->order_lampiran == '' ? '-' : $request->order_lampiran,
            'order_keterangan'      => $request->order_keterangan == '' ? '-' : $request->order_keterangan,
            'order_created'         => Auth::user()->user_id,
        ]);

        // If payment keterangan has COD
        if ($request->has('lunas')) {

            $payment_bukti = $request->file('payment_bukti') ?? null;

            if ($payment_bukti && $payment_bukti->isValid()) {

                $bukti = $request->file('payment_bukti');
                $bukti_bayar = 'bukti_bayar-' . rand(1, 100000) . '.' . $bukti->getClientOriginalExtension();

                // Store the original image
                $path = Storage::putFileAs('public/bukti_bayar', $bukti, $bukti_bayar);

                // Insert Into Order Payment
                $payment = OrderPayment::updateOrCreate([
                    'payment_id'            => $request->payment_id,
                ], [
                    'order_id'              => $order->order_id,
                    'payment_keterangan'    => $request->payment_keterangan,
                    'payment_status'        => $request->payment_status,
                    'payment_tanggal'       => $request->payment_tanggal,
                    'payment_method'        => 'bayar-langsung',
                    'payment_bukti'         => $bukti_bayar,
                    'user_id'               => Auth::user()->user_id,
                ]);
            } else {
                // Insert Into Order Payment
                $payment = OrderPayment::updateOrCreate([
                    'payment_id'            => $request->payment_id,
                ], [
                    'order_id'              => $order->order_id,
                    'payment_keterangan'    => $request->payment_keterangan,
                    'payment_status'        => $request->payment_status,
                    'payment_tanggal'       => $request->payment_tanggal,
                    'payment_method'        => 'bayar-langsung',
                    'payment_bukti'         => '-',
                    'user_id'               => Auth::user()->user_id,
                ]);
            }

            // If payment keterangan has CAD
        } else if ($request->has('bayar-makassar')) {

            // Insert Into Order Payment
            $payment = OrderPayment::updateOrCreate([
                'payment_id'            => $request->payment_id,
            ], [
                'order_id'              => $order->order_id,
                'payment_keterangan'    => $request->payment_keterangan,
                'payment_status'        => 'blm-lunas',
                'payment_method'        => 'bayar-makassar',
                'payment_date'          => null,
                'payment_bukti'         => null,
                'user_id'               => null,
            ]);
        } else if ($request->has('bayar-surabaya')) {

            // Insert Into Order Payment
            $payment = OrderPayment::updateOrCreate([
                'payment_id'            => $request->payment_id,
            ], [
                'order_id'              => $order->order_id,
                'payment_keterangan'    => $request->payment_keterangan,
                'payment_status'        => 'blm-lunas',
                'payment_method'        => 'bayar-surabaya',
                'payment_date'          => null,
                'payment_bukti'         => null,
                'user_id'               => null,
            ]);
        }

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Anda telah berhasil disimpan!',
        ]);
    }

    // ORDER EDIT
    public function orderEdit(Request $request)
    {
        $order  = Order::with(['payment'])->where('order_id', $request->order_id)->first();

        return response()->json($order);
    }

    // ORDER INDEX TO VALIDATE PAYMENT
    public function validatePaymentIndex(Request $request)
    {
        $orders   =   OrderPayment::with(['order'])->where('payment_status', 'blm-lunas')->get();

        $order    = [];
        $no       = 1;
        foreach ($orders as $item) {
            $order_id       = $item->order->order_id;
            $order_noresi   = $item->order->order_noresi;
            $order_tanggal  = $item->order->order_tanggal;
            $select         = '<input type="checkbox" class="row-checkbox form-check-input is-valid" value="' . $order_id . '">';
            $order_pengirim = $item->order->order_pengirim;
            $order_penerima = $item->order->order_penerima;
            $order_total    = 'Rp.' . number_format($item->order->order_total);

            // Order status validate badge color
            if ($item->order->order_status == 'terdaftar') {
                $order_status = '<div class="badge bg-secondary">' . strtoupper($item->order->order_status) . '</div>';
            } else if ($item->order->order_status == 'on-progress') {
                $order_status = '<div class="badge bg-warning">' . strtoupper($item->order->order_status) . '</div>';
            } else {
                $order_status = '<div class="badge bg-success">' . strtoupper($item->order->order_status) . '</div>';
            }

            $payment_status = '<div class="badge bg-danger">' . strtoupper($item->payment_status) . '</div>';
            $payment_method = ucfirst($item->payment_method);

            $order[] = [
                'index'          => $no++,
                'select'         => $select,
                'order_id'       => $order_id,
                'order_noresi'   => $order_noresi,
                'order_tanggal'  => $order_tanggal,
                'order_pengirim' => $order_pengirim,
                'order_penerima' => $order_penerima,
                'order_total'    => $order_total,
                'order_status'   => $order_status,
                'payment_status' => $payment_status,
                'payment_method' => $payment_method,
            ];
        }

        return DataTables::of($order)
            ->rawColumns(['order_status', 'payment_status', 'select']) // Specify the columns containing HTML
            ->toJson();
    }

    // ORDER DETAIL
    public function orderDetail(Request $request)
    {
        $order  = Order::with(['payment.userAcc', 'userCreate'])->where('order_id', $request->order_id)->first();
        return response()->json($order);
    }

    // DOWNLOAD BUKTI
    public function downloadBukti($order_id)
    {
        // Find the data by order_id (Assuming you have an Order model)
        $order  = Order::with(['payment'])->where('order_id', $order_id)->first();

        // Get the image file name from the order data (replace 'image_column_name' with the actual column name)
        $filename = $order->payment->payment_bukti; // Replace 'image_column_name' with the actual column name storing the file name

        // Ensure the file exists in the storage
        if (Storage::disk('public')->exists('bukti_bayar/' . $filename)) {
            $file = storage_path('app/public/bukti_bayar/' . $filename);

            // You can also use the response()->download() method to force download
            return response()->file($file);
        }

        // If the file doesn't exist, redirect or show an error message
        // For example, redirect to a 404 page
        abort(404, 'File not found');
    }

    // LOAD ORDER SELECTED
    public function loadOrderSelected(Request $request)
    {
        $order  = Order::with(['payment'])->whereIn('order_id', $request->order_id)->get();

        return response()->json($order);
    }

    // VALIDATE ORDER STORE
    public function orderValidateStore(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'payment_tanggal'           => 'required',
            // 'payment_method'            => 'required',
            'payment_bukti'             => 'required|mimes:jpeg,jpg,png|max:5048',
        ], [
            'payment_tanggal.required'  => 'Tanggal Pembayaran Harus di Isi!',
            // 'payment_method.required'   => 'Metode Pembayaran Harus di Isi!',
            'payment_bukti.required'    => 'Bukti Pembayaran Harus di Isi!',
            'payment_bukti.max'         => 'Bukti Pembayaran Tidak boleh lebih besar dari 5048 kilobyte!',
            'payment_bukti.mimes'       => 'Bukti Pembayaran Harus berupa file dengan tipe: jpeg, jpg, png!',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // STORE BUKTI PEMBAYARAN
        $bukti = $request->file('payment_bukti');
        $bukti_bayar = 'bukti_bayar-' . rand(1, 100000) . '.' . $bukti->getClientOriginalExtension();

        // Store the original image
        $path = Storage::putFileAs('public/bukti_bayar', $bukti, $bukti_bayar);

        for ($x = 0; $x < count($request->order_id); $x++) {

            $order  = OrderPayment::where('order_id', $request->order_id[$x]);
            $order->update([
                'payment_status'    => 'lunas',
                'payment_bukti'     => $bukti_bayar,
                'payment_tanggal'   => $request->payment_tanggal,
                // 'payment_method'    => $request->payment_method,
                'user_id'           => Auth::user()->user_id,
            ]);
        }

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Anda telah berhasil disimpan!',
        ]);
    }

    // ORDER TOTAL
    public function orderTotal()
    {
        $total = Order::sum('order_total');
        $berat = Order::sum('order_berat');
        $volume = Order::sum('order_volume');
        return response()->json([
            'total'  => $total,
            'berat'  => $berat,
            'volume' => $volume,
        ]);
    }

    // PRINT SURAT JALAN
    public function orderPrint(Request $request)
    {
        // Get the data to be displayed in the PDF
        $order = Order::find($request->order_id);

        // Load the HTML view with the data
        $html = view('layout-print.suratJalan', ['order' => $order])->render();

        // Create a new Dompdf instance
        $dompdf = new Dompdf();

        // Load the HTML into Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Get the PDF content as a string
        $pdfContent = $dompdf->output();

        // Return the PDF content with appropriate headers
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="Surat Jalan-' . $order->order_noresi . '.pdf"');
    }

    // ORDER RECEIVE
    public function orderReceive(Request $request)
    {
        $order  = Order::find($request->order_id);
        $order->update([
            'order_status'              => 'telah-sampai',
            'order_received_validation' => Auth::user()->user_id,
            'order_received'            => $request->order_received,
        ]);

        return response()->json(['status' => 'Status pesanan diperbarui menjadi berhasil terkirim']);
    }

    // AUTOFILL PENERIMA & PENGIRIM
    public function getInput(Request $request)
    {
        // Determine the column to pluck based on the request
        $pluckColumn = $request->has('query')
            ? 'query'
            : ($request->has('nohp')
                ? 'nohp'
                : ($request->has('address')
                    ? 'address'
                    : 'query')); // Default to 'query' if no specific condition is met

        // Fetch historical search data from the database for the authenticated user
        $query = InputHistory::query(); // Get the base query

        if ($request->has('query')) {
            $query->where('query', 'like', '%' . $request->input('query') . '%');
        }

        if ($request->has('nohp')) {
            $query->where('nohp', 'like', '%' . $request->input('nohp') . '%');
        }

        if ($request->has('address')) {
            $query->where('address', 'like', '%' . $request->input('address') . '%');
        }

        // Pluck the column based on the determined $pluckColumn value
        $history = $query->pluck($pluckColumn);



        if ($history->isEmpty()) {
            // If historical search data not found, return an empty response
            return response()->json([]);
        } else {
            // If historical search data found, return the matched historical search data
            return response()->json($history);
        }
    }

    // AUTOFILL PENERIMA & PENGIRIM
    public function storeInput(Request $request)
    {
        if ($request->has('query')) {
            // Save the search query to the InputHistory table if it doesn't exist
            $existingHistory = InputHistory::where('query', $request->input('query'))->exists();

            if (!$existingHistory) {
                InputHistory::create([
                    'query' => $request->input('query'),
                ]);
            }
        } else if ($request->has('nohp')) {
            // Save the search query to the InputHistory table if it doesn't exist
            $existingHistory = InputHistory::where('nohp', $request->input('nohp'))->exists();

            if (!$existingHistory) {
                InputHistory::create([
                    'nohp' => $request->input('nohp'),
                ]);
            }
        } else if ($request->has('address')) {
            // Save the search query to the InputHistory table if it doesn't exist
            $existingHistory = InputHistory::where('address', $request->input('address'))->exists();

            if (!$existingHistory) {
                InputHistory::create([
                    'address' => $request->input('address'),
                ]);
            }
        }

        // Return an empty response, as we don't need to return data to the input field
        return response()->json([]);
    }
}
