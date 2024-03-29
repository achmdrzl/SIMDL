<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\InHandling;
use App\Models\Laporan;
use App\Models\Order;
use App\Models\OutGaji;
use App\Models\OutModal;
use App\Models\OutOperasional;
use App\Models\OutTransportasi;
use App\Models\Pengeluaran;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    public function laporanIndex(Request $request)
    {
        $laporans       = Laporan::with(['handling', 'operasional', 'gaji'])->get();

        if ($request->ajax()) {
            $laporans       = Laporan::with(['handling', 'operasional', 'gaji'])->latest()->get();
            return DataTables::of($laporans)
                ->addIndexColumn()
                ->addColumn('laporan_tanggal', function ($item) {
                    return date('d-M-Y', strtotime($item->laporan_tanggal));
                })
                ->addColumn('laporan_total_handling', function ($item) {
                    return 'Rp. ' . number_format($item->laporan_total_handling);
                })
                ->addColumn('laporan_total_omset', function ($item) {
                    $order = Order::whereBetween('order_tanggal', [$item->laporan_tanggal_awal, $item->laporan_tanggal_akhir])->sum('order_total');
                    // return 'Rp. ' . number_format($item->laporan_total_omset);
                    return 'Rp. ' . number_format($order);
                })
                ->addColumn('laporan_total_operasional', function ($item) {
                    return 'Rp. ' . number_format($item->laporan_total_operasional);
                })
                ->addColumn('laporan_total_pengeluaran_mks', function ($item) {
                    return 'Rp. ' . number_format($item->laporan_total_pengeluaran_mks);
                })
                ->addColumn('laporan_total_transportasi', function ($item) {
                    return 'Rp. ' . number_format($item->laporan_total_transportasi);
                })
                ->addColumn('laporan_total_gaji', function ($item) {
                    return 'Rp. ' . number_format($item->laporan_total_gaji);
                })
                ->addColumn('laporan_total', function ($item) {

                    $order = Order::whereBetween('order_tanggal', [$item->laporan_tanggal_awal, $item->laporan_tanggal_akhir])->sum('order_total');

                    $laba_bersih = ($order + $item->laporan_total_handling) - ($item->laporan_total_operasional + $item->laporan_total_pengeluaran_mks + $item->laporan_total_transportasi + $item->laporan_total_gaji);

                    // return 'Rp. ' . number_format($item->laporan_total);
                    return 'Rp. ' . number_format($laba_bersih);
                })
                ->addColumn('action', function ($item) {

                    $btn = '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="laporan-print" title="PRINT SURAT LAPORAN" data-id="' . $item->laporan_id . '"><span class="material-icons btn-sm">print</span></button>';

                    $btn = $btn . '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="laporan-detail" title="DETAIL LAPORAN" data-id="' . $item->laporan_id . '"><span class="material-icons btn-sm">visibility</span></button>';

                    if(Auth::user()->role == 'superadmin'){
                        $btn = $btn . '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="laporan-delete" title="DELETE LAPORAN" data-id="' . $item->laporan_id . '"><span class="material-icons btn-sm">delete</span></button>';
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('laporan.data-laporan');
    }

    // GET DATA ORDER
    public function laporanorderdata(Request $request)
    {
        $orders = Order::with(['payment'])->whereBetween('order_tanggal', [$request->laporan_tanggal_awal, $request->laporan_tanggal_akhir])->get();

        $total_order = $orders->sum('order_total');

        $pengeluaran = Pengeluaran::with(['modal', 'operasional', 'gaji', 'transportasi'])->whereBetween('pengeluaran_tanggal', [$request->laporan_tanggal_awal, $request->laporan_tanggal_akhir])->get();

        $total_pengeluaran  = $pengeluaran->sum('pengeluaran_total');
        $total_modal        = $pengeluaran->sum('pengeluaran_total_modal');
        $sisa_saldo         = $pengeluaran->sum('pengeluaran_sisa_saldo');


        // If all orders have valid order_status, return them as JSON
        return response()->json([
            'data'              => $orders,
            'total_order'       => $total_order,
            'pengeluaran'       => $pengeluaran,
            'total_modal'       => $total_modal,
            'total_pengeluaran' => $total_pengeluaran,
            'sisa_saldo'        => $sisa_saldo,
        ]);
    }

    // STORE DATA LAPORAN
    public function laporanStore(Request $request)
    {
        // dd($request->all());
        //define validation rules
        $validator = Validator::make($request->all(), [
            'laporan_tanggal'              => 'required|date',
            'laporan_tanggal_awal'         => 'required|date',
            'laporan_tanggal_akhir'        => 'required|date',
            // 'handling_kota.*'              => 'required|min:1|string',
            // 'handling_tarif.*'             => 'required|min:1|integer',
            // 'handling_berat.*'             => 'required|min:1|integer',
            // 'handling_total.*'             => 'required|min:1|integer',
            'operasional_keterangan.*'     => 'required|min:1|string',
            'operasional_total.*'          => 'required|min:1|integer',
            'operasional_bukti.*'          => 'required|min:1|image|mimes:jpeg,png,jpg,gif|max:5048',
            'gaji_keterangan.*'            => 'required|min:1|string',
            'gaji_total.*'                 => 'required|min:1|string',
            'gaji_bukti.*'                 => 'required|min:1|image|mimes:jpeg,png,jpg,gif|max:5048',
            'transportasi_keterangan.*'    => 'required|min:1|string',
            'transportasi_total.*'         => 'required|min:1|integer',
            'transportasi_bukti.*'         => 'required|min:1|image|mimes:jpeg,png,jpg,gif|max:5048',
        ], [
            'laporan_tanggal.required'              => 'Tanggal Harus di isi!',
            'laporan_tanggal_awal.required'         => 'Tanggal Awal Harus di isi!',
            'laporan_tanggal_akhir.required'        => 'Tanggal Akhir Harus di isi!',
            // 'handling_kota.*.required'              => 'Kota Harus di isi setidaknya satu isian!',
            // 'handling_tarif.*.required'             => 'Tarif Harus di isi setidaknya satu isian!',
            // 'handling_berat.*.required'             => 'Berat Harus di isi setidaknya satu isian!',
            // 'handling_total.*.required'             => 'Total Harus di isi setidaknya satu isian!',
            'operasional_total.*.required'          => 'Total Operasional Harus di isi setidaknya satu isian!',
            'operasional_keterangan.*.required'     => 'Keterangan Operasional Harus di isi setidaknya satu isian!',
            'operasional_bukti.*.required'          => 'Bukti Operasional Harus di Upload!',
            'operasional_bukti.*.image'             => 'Bukti Operasional Harus berupa gambar!',
            'operasional_bukti.*.mimes'             => 'Bukti Operasional Harus berformat .jpg,.jpeg,.png,.gif!',
            'operasional_bukti.*.max'               => 'Bukti Operasional Harus berukuran dibawah 5048kb',
            'gaji_keterangan.*.required'            => 'Keterangan Gaji Harus di isi setidaknya satu isian!',
            'gaji_total.*.required'                 => 'Total Gaji Harus di isi setidaknya satu isian!',
            'gaji_bukti.*.required'                 => 'Slip Bukti Gaji Harus di Upload!',
            'gaji_bukti.*.image'                    => 'Slip Bukti Gaji Harus berupa gambar!',
            'gaji_bukti.*.mimes'                    => 'Slip Bukti Gaji Harus berformat .jpg,.jpeg,.png,.gif!',
            'gaji_bukti.*.max'                      => 'Slip Bukti Gaji Harus berukuran dibawah 5048kb',
            'transportasi_keterangan.*.required'    => 'Keterangan Transportasi Harus di isi setidaknya satu isian!',
            'transportasi_total.*.required'         => 'Total Transportasi Harus di isi setidaknya satu isian!',
            'transportasi_bukti.*.required'         => 'Bukti Transportasi Harus di Upload!',
            'transportasi_bukti.*.image'            => 'Bukti Transportasi Harus berupa gambar!',
            'transportasi_bukti.*.mimes'            => 'Bukti Transportasi Harus berformat .jpg,.jpeg,.png,.gif!',
            'transportasi_bukti.*.max'              => 'Bukti Transportasi Harus berukuran dibawah 5048kb',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // INSERT TO LAPORAN
        $laporan_total_omset        = $request->laporan_total_omset;
        $laporan_total_handling     = array_sum($request->handling_total);
        $laporan_total_operasional  = array_sum($request->operasional_total);
        $laporan_total_transportasi = array_sum($request->transportasi_total);
        $laporan_total_gaji         = array_sum($request->gaji_total);
        $laporan_pengeluaran_total  = $request->pengeluaran_total;
        $laporan_total              = ($laporan_total_omset + $laporan_total_handling) - ($laporan_total_operasional + $laporan_total_transportasi + $laporan_total_gaji + $laporan_pengeluaran_total);

        $laporan = Laporan::updateOrCreate([
            'laporan_id' => $request->laporan_id
        ], [
            'laporan_tanggal'               => $request->laporan_tanggal,
            'laporan_tanggal_awal'          => $request->laporan_tanggal_awal,
            'laporan_tanggal_akhir'         => $request->laporan_tanggal_akhir,
            'laporan_total_omset'           => $laporan_total_omset,
            'laporan_total_handling'        => $laporan_total_handling,
            'laporan_total_operasional'     => $laporan_total_operasional,
            'laporan_total_transportasi'    => $laporan_total_transportasi,
            'laporan_total_pengeluaran_mks' => $laporan_pengeluaran_total,
            'laporan_total_gaji'            => $laporan_total_gaji,
            'laporan_total'                 => $laporan_total,
            'user_id'                       => Auth::user()->user_id,
        ]);

        // INSERT INTO HANDLING
        if (count($request->handling_total) != null) {
            for ($x = 0; $x < count($request->handling_kota); $x++) {
                $handling = InHandling::updateOrCreate([
                    'handling_id'   => $request->handling_id,
                ], [
                    'laporan_id'        => $laporan->laporan_id,
                    'handling_kota'     => $request->handling_kota[$x],
                    'handling_tarif'    => $request->handling_tarif[$x],
                    'handling_berat'    => $request->handling_berat[$x],
                    'handling_total'    => $request->handling_total[$x],
                ]);
            }
        }

        // INSERT INTO OPERASIONAL
        foreach ($request->operasional_keterangan as $x => $keterangan) {

            $operasional_bukti = $request->file('operasional_bukti')[$x] ?? null;

            if ($operasional_bukti && $operasional_bukti->isValid()) {
                $bukti_operasional = 'bukti_operasional-' . rand(1, 100000) . '.' . $operasional_bukti->getClientOriginalExtension();

                // Store the original image
                $path = Storage::putFileAs('public/bukti_operasional', $operasional_bukti, $bukti_operasional);

                $operasional = OutOperasional::updateOrCreate([
                    'operasional_id'  => $request->operasional_id,
                ], [
                    'laporan_id'             => $laporan->laporan_id,
                    'operasional_keterangan' => $keterangan,
                    'operasional_total'      => $request->operasional_total[$x],
                    'operasional_bukti'      => $bukti_operasional,
                    'status'                 => 'sby',
                ]);
            } else {
                $operasional = OutOperasional::updateOrCreate([
                    'operasional_id'  => $request->operasional_id,
                ], [
                    'laporan_id'              => $laporan->laporan_id,
                    'operasional_keterangan' => $keterangan,
                    'operasional_total'      => $request->operasional_total[$x],
                    'operasional_bukti'      => '-',
                    'status'                 => 'sby',
                ]);
            }
        }

        // INSERT INTO GAJI
        foreach ($request->gaji_keterangan as $x => $keterangan) {
            $gaji_bukti = $request->file('gaji_bukti')[$x] ?? null;

            if ($gaji_bukti && $gaji_bukti->isValid()) {
                $bukti_gaji = 'bukti_gaji-' . rand(1, 100000) . '.' . $gaji_bukti->getClientOriginalExtension();

                // Store the original image
                $path = Storage::putFileAs('public/bukti_gaji', $gaji_bukti, $bukti_gaji);

                $gaji = OutGaji::updateOrCreate([
                    'gaji_id'  => $request->gaji_id,
                ], [
                    'laporan_id'      => $laporan->laporan_id,
                    'gaji_keterangan' => $keterangan,
                    'gaji_total'      => $request->gaji_total[$x],
                    'gaji_bukti'      => $bukti_gaji,
                    'status'          => 'sby',
                ]);
            } else {
                $gaji = OutGaji::updateOrCreate([
                    'gaji_id'  => $request->gaji_id,
                ], [
                    'laporan_id'      => $laporan->laporan_id,
                    'gaji_keterangan' => $keterangan,
                    'gaji_total'      => $request->gaji_total[$x],
                    'gaji_bukti'      => '-',
                    'status'                 => 'sby',
                ]);
            }
        }

        // INSERT INTO TRANSPORTASI
        foreach ($request->transportasi_keterangan as $x => $keterangan) {
            $transportasi_bukti = $request->file('transportasi_bukti')[$x] ?? null;

            if ($transportasi_bukti && $transportasi_bukti->isValid()) {
                $bukti_transportasi = 'bukti_transportasi-' . rand(1, 100000) . '.' . $transportasi_bukti->getClientOriginalExtension();

                // Store the original image
                $path = Storage::putFileAs('public/bukti_transportasi', $transportasi_bukti, $bukti_transportasi);

                $transportasi = OutTransportasi::updateOrCreate([
                    'transportasi_id'  => $request->transportasi_id,
                ], [
                    'laporan_id'              => $laporan->laporan_id,
                    'transportasi_keterangan' => $keterangan,
                    'transportasi_total'      => $request->transportasi_total[$x],
                    'transportasi_bukti'      => $bukti_transportasi,
                    'status'                  => 'sby',
                ]);
            } else {
                $transportasi = OutTransportasi::updateOrCreate([
                    'transportasi_id'  => $request->transportasi_id,
                ], [
                    'laporan_id'              => $laporan->laporan_id,
                    'transportasi_keterangan' => $keterangan,
                    'transportasi_total'      => $request->transportasi_total[$x],
                    'transportasi_bukti'      => '-',
                    'status'                  => 'sby',
                ]);
            }
        }

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Anda telah berhasil disimpan!',
        ]);
    }

    // LAPORAN DETAIL
    public function laporanDetail(Request $request)
    {
        $laporan    = Laporan::with(['handling', 'transportasi', 'operasional', 'gaji'])->where('laporan_id', $request->laporan_id)->first();

        $order = Order::whereBetween('order_tanggal', [$laporan->laporan_tanggal_awal, $laporan->laporan_tanggal_akhir])->sum('order_total');

        $laba_bersih = ($order + $laporan->laporan_total_handling) - ($laporan->laporan_total_operasional + $laporan->laporan_total_pengeluaran_mks + $laporan->laporan_total_transportasi + $laporan->laporan_total_gaji);

        return response()->json([
            'laporan'       => $laporan,
            'order_total'   => $order,
            'laba_bersih'   => $laba_bersih,
        ]);
    }

    // // DOWNLOAD BUKTI
    // public function downloadBuktiPengeluaran($objek_id)
    // {
    //     // Extract the prefix "gaji"
    //     $prefix1 = substr($objek_id, 0, -1);

    //     // Extract the number "2"
    //     $number = intval(substr($objek_id, -1));

    //     if ($prefix1 == 'gaji') {
    //         // Find the data by order_id (Assuming you have an Order model)
    //         $gaji  = OutGaji::find($number);

    //         if (!$gaji) {
    //             abort(404, 'File not found');
    //         }

    //         // Get the image file name from the order data (replace 'image_column_name' with the actual column name)
    //         $filename = $gaji->gaji_bukti; // Replace 'image_column_name' with the actual column name storing the file name

    //         $disk = Storage::disk('public');
    //         if ($disk->exists('bukti_gaji/' . $filename)) {
    //             // Determine the file's content type based on the file extension
    //             $mimeTypes = [
    //                 'pdf' => 'application/pdf',
    //                 'jpg' => 'image/jpeg',
    //                 'jpeg' => 'image/jpeg',
    //                 'png' => 'image/png',
    //                 'txt' => 'text/plain',
    //                 // Add more mime types as needed
    //             ];

    //             $extension = pathinfo($filename, PATHINFO_EXTENSION);
    //             $contentType = isset($mimeTypes[$extension]) ? $mimeTypes[$extension] : 'application/octet-stream';

    //             $headers = [
    //                 'Content-Type' => $contentType,
    //                 'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    //             ];

    //             return response()->stream(function () use ($disk, $filename) {
    //                 echo $disk->get('bukti_gaji/' . $filename);
    //             }, 200, $headers);
    //         }
    //         // If the file doesn't exist, redirect or show an error message
    //         // For example, redirect to a 404 page
    //         abort(404, 'File not found');
    //     } else if ($prefix1 == 'operasional') {
    //         // Find the data by order_id (Assuming you have an Order model)
    //         $operasional  = OutOperasional::find($number);

    //         if (!$operasional) {
    //             abort(404, 'File not found');
    //         }

    //         // Get the image file name from the order data (replace 'image_column_name' with the actual column name)
    //         $filename = $operasional->operasional_bukti; // Replace 'image_column_name' with the actual column name storing the file name

    //         $disk = Storage::disk('public');
    //         if ($disk->exists('bukti_operasional/' . $filename)) {
    //             // Determine the file's content type based on the file extension
    //             $mimeTypes = [
    //                 'pdf' => 'application/pdf',
    //                 'jpg' => 'image/jpeg',
    //                 'jpeg' => 'image/jpeg',
    //                 'png' => 'image/png',
    //                 'txt' => 'text/plain',
    //                 // Add more mime types as needed
    //             ];

    //             $extension = pathinfo($filename, PATHINFO_EXTENSION);
    //             $contentType = isset($mimeTypes[$extension]) ? $mimeTypes[$extension] : 'application/octet-stream';

    //             $headers = [
    //                 'Content-Type' => $contentType,
    //                 'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    //             ];

    //             return response()->stream(function () use ($disk, $filename) {
    //                 echo $disk->get('bukti_operasional/' . $filename);
    //             }, 200, $headers);
    //         }
    //         // If the file doesn't exist, redirect or show an error message
    //         // For example, redirect to a 404 page
    //         abort(404, 'File not found');
    //     } else {

    //         // Find the data by order_id (Assuming you have an Order model)
    //         $transportasi  = OutTransportasi::find($number);

    //         // Get the image file name from the order data (replace 'image_column_name' with the actual column name)
    //         $filename = $transportasi->transportasi_bukti; // Replace 'image_column_name' with the actual column name storing the file name

    //         $disk = Storage::disk('public');
    //         if ($disk->exists('bukti_transportasi/' . $filename)) {
    //             // Determine the file's content type based on the file extension
    //             $mimeTypes = [
    //                 'pdf' => 'application/pdf',
    //                 'jpg' => 'image/jpeg',
    //                 'jpeg' => 'image/jpeg',
    //                 'png' => 'image/png',
    //                 'txt' => 'text/plain',
    //                 // Add more mime types as needed
    //             ];

    //             $extension = pathinfo($filename, PATHINFO_EXTENSION);
    //             $contentType = isset($mimeTypes[$extension]) ? $mimeTypes[$extension] : 'application/octet-stream';

    //             $headers = [
    //                 'Content-Type' => $contentType,
    //                 'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    //             ];

    //             return response()->stream(function () use ($disk, $filename) {
    //                 echo $disk->get('bukti_transportasi/' . $filename);
    //             }, 200, $headers);
    //         }
    //         // If the file doesn't exist, redirect or show an error message
    //         // For example, redirect to a 404 page
    //         abort(404, 'File not found');
    //     }
    // } 

    public function downloadBuktiPengeluaranGaji($objek_id)
    {

        // Find the data by order_id (Assuming you have an Order model)
        $gaji  = OutGaji::find($objek_id);

        // Get the image file name from the order data (replace 'image_column_name' with the actual column name)
        $filename = $gaji->gaji_bukti; // Replace 'image_column_name' with the actual column name storing the file name

        // Ensure the file exists in the storage
        if (Storage::disk('public')->exists('bukti_gaji/' . $filename)) {
            $file = storage_path('app/public/bukti_gaji/' . $filename);

            // You can also use the response()->download() method to force download
            return response()->file($file);
        }
        // If the file doesn't exist, redirect or show an error message
        // For example, redirect to a 404 page
        abort(404, 'File not found');

        // // Extract the prefix "gaji"
        // $prefix1 = substr($objek_id, 0, -1);

        // // Extract the number "2"
        // $number = intval(substr($objek_id, -1));

        // if ($prefix1 == 'gaji') {
        //     // Find the data by order_id (Assuming you have an Order model)
        //     $gaji  = OutGaji::find($number);

        //     // Get the image file name from the order data (replace 'image_column_name' with the actual column name)
        //     $filename = $gaji->gaji_bukti; // Replace 'image_column_name' with the actual column name storing the file name

        //     // Ensure the file exists in the storage
        //     if (Storage::disk('public')->exists('bukti_gaji/' . $filename)) {
        //         $file = storage_path('app/public/bukti_gaji/' . $filename);

        //         // You can also use the response()->download() method to force download
        //         return response()->file($file);
        //     }
        //     // If the file doesn't exist, redirect or show an error message
        //     // For example, redirect to a 404 page
        //     abort(404, 'File not found');
        // } else if ($prefix1 == 'operasional') {
        //     // Find the data by order_id (Assuming you have an Order model)
        //     $operasional  = OutOperasional::find($number);

        //     // Get the image file name from the order data (replace 'image_column_name' with the actual column name)
        //     $filename = $operasional->operasional_bukti; // Replace 'image_column_name' with the actual column name storing the file name

        //     // Ensure the file exists in the storage
        //     if (Storage::disk('public')->exists('bukti_operasional/' . $filename)) {
        //         $file = storage_path('app/public/bukti_operasional/' . $filename);

        //         // You can also use the response()->download() method to force download
        //         return response()->file($file);
        //     }

        //     // If the file doesn't exist, redirect or show an error message
        //     // For example, redirect to a 404 page
        //     abort(404, 'File not found');
        // } else {

        //     // Find the data by order_id (Assuming you have an Order model)
        //     $transportasi  = OutTransportasi::find($number);

        //     // Get the image file name from the order data (replace 'image_column_name' with the actual column name)
        //     $filename = $transportasi->transportasi_bukti; // Replace 'image_column_name' with the actual column name storing the file name

        //     // Ensure the file exists in the storage
        //     if (Storage::disk('public')->exists('bukti_transportasi/' . $filename)) {
        //         $file = storage_path('app/public/bukti_transportasi/' . $filename);

        //         // You can also use the response()->download() method to force download
        //         return response()->file($file);
        //     }
        //     // If the file doesn't exist, redirect or show an error message
        //     // For example, redirect to a 404 page
        //     abort(404, 'File not found');
        // }
    }

    public function downloadBuktiPengeluaranTransportasi($objek_id)
    {
        // Find the data by order_id (Assuming you have an Order model)
        $transportasi  = OutTransportasi::find($objek_id);

        // Get the image file name from the order data (replace 'image_column_name' with the actual column name)
        $filename = $transportasi->transportasi_bukti; // Replace 'image_column_name' with the actual column name storing the file name

        // Ensure the file exists in the storage
        if (Storage::disk('public')->exists('bukti_transportasi/' . $filename)) {
            $file = storage_path('app/public/bukti_transportasi/' . $filename);

            // You can also use the response()->download() method to force download
            return response()->file($file);
        }
        // If the file doesn't exist, redirect or show an error message
        // For example, redirect to a 404 page
        abort(404, 'File not found');
    }

    public function downloadBuktiPengeluaranOperasional($objek_id)
    {
        // Find the data by order_id (Assuming you have an Order model)
        $operasional  = OutOperasional::find($objek_id);

        // Get the image file name from the order data (replace 'image_column_name' with the actual column name)
        $filename = $operasional->operasional_bukti; // Replace 'image_column_name' with the actual column name storing the file name

        // Ensure the file exists in the storage
        if (Storage::disk('public')->exists('bukti_operasional/' . $filename)) {
            $file = storage_path('app/public/bukti_operasional/' . $filename);

            // You can also use the response()->download() method to force download
            return response()->file($file);
        }

        // If the file doesn't exist, redirect or show an error message
        // For example, redirect to a 404 page
        abort(404, 'File not found');
    }

    // PRINT LAPORAN
    public function laporanPrint(Request $request)
    {
        // Get the data to be displayed in the PDF
        $laporan = Laporan::with(['handling', 'transportasi', 'operasional', 'gaji'])->where('laporan_id', $request->laporan_id)->first();

        $order_sum = Order::whereBetween('order_tanggal', [$laporan->laporan_tanggal_awal, $laporan->laporan_tanggal_akhir])->sum('order_total');

        $laba_bersih = ($order_sum + $laporan->laporan_total_handling) - ($laporan->laporan_total_operasional + $laporan->laporan_total_pengeluaran_mks + $laporan->laporan_total_transportasi + $laporan->laporan_total_gaji);

        // Load the HTML view with the data
        $html = view('layout-print.laporanPrint', ['laporan' => $laporan, 'order_sum' => $order_sum, 'laba_bersih' => $laba_bersih])->render();

        // Create a new Dompdf instance
        $dompdf = new Dompdf();

        // Load the HTML into Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'potrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Get the PDF content as a string
        $pdfContent = $dompdf->output();

        // Return the PDF content with appropriate headers
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="Laporan-' . $laporan->laporan_tanggal . '.pdf"');
    }

    // DESTROY LAPORAN
    public function laporanDestroy(Request $request)
    {
        $laporan = Laporan::find($request->laporan_id);

        if (!$laporan) {
            return response()->json(['error' => 'Laporan not found.'], 404);
        }

        // Use relationships to delete related records
        $laporan->gaji()->delete();
        $laporan->transportasi()->delete();
        $laporan->operasional()->delete();
        $laporan->handling()->delete();

        // Delete the main record
        $laporan->delete();

        // Return a success message or perform any other action after the updates
        return response()->json(['status' => 'Laporan Berhasil di Hapus!']);
    }
}
