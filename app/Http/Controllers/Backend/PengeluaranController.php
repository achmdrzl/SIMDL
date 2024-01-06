<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\InHandling;
use App\Models\Laporan;
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

class PengeluaranController extends Controller
{
    // PENGELUARAN INDEX
    public function pengeluaranIndex(Request $request)
    {
        $pengeluarans       = Pengeluaran::with(['modal', 'operasional', 'gaji'])->get();

        if ($request->ajax()) {
            $pengeluarans       = Pengeluaran::with(['modal', 'operasional', 'gaji', 'transportasi'])->latest()->get();
            return DataTables::of($pengeluarans)
                ->addIndexColumn()
                ->addColumn('pengeluaran_tanggal', function ($item) {
                    return date('d-M-Y', strtotime($item->pengeluaran_tanggal));
                })
                ->addColumn('pengeluaran_total_modal', function ($item) {
                    return 'Rp. ' . number_format($item->pengeluaran_total_modal);
                })
                ->addColumn('pengeluaran_total_operasional', function ($item) {
                    return 'Rp. ' . number_format($item->pengeluaran_total_operasional);
                })
                ->addColumn('pengeluaran_total_transportasi', function ($item) {
                    return 'Rp. ' . number_format($item->pengeluaran_total_transportasi);
                })
                ->addColumn('pengeluaran_total_gaji', function ($item) {
                    return 'Rp. ' . number_format($item->pengeluaran_total_gaji);
                })
                ->addColumn('pengeluaran_total', function ($item) {
                    return 'Rp. ' . number_format($item->pengeluaran_total);
                })
                ->addColumn('action', function ($item) {

                    // $btn = '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="laporan-print" title="PRINT SURAT LAPORAN" data-id="' . $item->pengeluaran_id . '"><span class="material-icons btn-sm">print</span></button>';

                    $btn = '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="pengeluaran-detail" title="DETAIL PENGELUARAN" data-id="' . $item->pengeluaran_id . '"><span class="material-icons btn-sm">visibility</span></button>';

                    if (Auth::user()->role == 'superadmin') {
                        $btn = $btn . '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="pengeluaran-delete" title="DELETE PENGELUARAN" data-id="' . $item->pengeluaran_id . '"><span class="material-icons btn-sm">delete</span></button>';
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('transaksi.data-pengeluaran');
    }

    // STORE DATA PENGELUARAN
    public function pengeluaranStore(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'pengeluaran_tanggal'          => 'required|date',
            // 'modal_keterangan.*'           => 'required|min:1|string',
            // 'modal_total.*'                => 'required|min:1|integer',
            // 'operasional_keterangan.*'     => 'required|min:1|string',
            // 'operasional_total.*'          => 'required|min:1|integer',
            // 'operasional_bukti.*'          => 'required|min:1|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'gaji_keterangan.*'            => 'required|min:1|string',
            // 'gaji_total.*'                 => 'required|min:1|string',
            // 'gaji_bukti.*'                 => 'required|min:1|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'transportasi_keterangan.*'    => 'required|min:1|string',
            // 'transportasi_total.*'         => 'required|min:1|string',
            // 'transportasi_bukti.*'         => 'required|min:1|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'pengeluaran_tanggal.required'          => 'Tanggal Harus di isi!',
            // 'modal_keterangan.*.required'           => 'Keterangan Harus di isi setidaknya satu isian!',
            // 'modal_total.*.required'                => 'Total Harus di isi setidaknya satu isian!',
            // 'operasional_total.*.required'          => 'Total Operasional Harus di isi setidaknya satu isian!',
            // 'operasional_keterangan.*.required'     => 'Keterangan Operasional Harus di isi setidaknya satu isian!',
            // 'operasional_bukti.*.required'          => 'Bukti Operasional Harus di Upload!',
            // 'operasional_bukti.*.image'             => 'Bukti Operasional Harus berupa gambar!',
            // 'operasional_bukti.*.mimes'             => 'Bukti Operasional Harus berformat .jpg,.jpeg,.png,.gif!',
            // 'operasional_bukti.*.max'               => 'Bukti Operasional Harus berukuran dibawah 2048kb',
            // 'gaji_keterangan.*.required'            => 'Keterangan Gaji Harus di isi setidaknya satu isian!',
            // 'gaji_total.*.required'                 => 'Total Gaji Harus di isi setidaknya satu isian!',
            // 'gaji_bukti.*.required'                 => 'Slip Bukti Gaji Harus di Upload!',
            // 'gaji_bukti.*.image'                    => 'Slip Bukti Gaji Harus berupa gambar!',
            // 'gaji_bukti.*.mimes'                    => 'Slip Bukti Gaji Harus berformat .jpg,.jpeg,.png,.gif!',
            // 'gaji_bukti.*.max'                      => 'Slip Bukti Gaji Harus berukuran dibawah 2048kb',
            // 'transportasi_keterangan.*.required'    => 'Keterangan Transportasi Harus di isi setidaknya satu isian!',
            // 'transportasi_total.*.required'         => 'Total Transportasi Harus di isi setidaknya satu isian!',
            // 'transportasi_bukti.*.required'         => 'Bukti Transportasi Harus di Upload!',
            // 'transportasi_bukti.*.image'            => 'Bukti Transportasi Harus berupa gambar!',
            // 'transportasi_bukti.*.mimes'            => 'Bukti Transportasi Harus berformat .jpg,.jpeg,.png,.gif!',
            // 'transportasi_bukti.*.max'              => 'Bukti Transportasi Harus berukuran dibawah 2048kb',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // INSERT TO PENGELUARAN
        $pengeluaran_total_modal        = array_sum($request->modal_total);
        $pengeluaran_total_operasional  = array_sum($request->operasional_total);
        $pengeluaran_total_transportasi = array_sum($request->transportasi_total);
        $pengeluaran_total_gaji         = array_sum($request->gaji_total);
        $pengeluaran_total              = $pengeluaran_total_operasional + $pengeluaran_total_transportasi + $pengeluaran_total_gaji + $pengeluaran_total_modal;
        $pengeluaran_sisa_saldo         = ($pengeluaran_total_modal) - ($pengeluaran_total_operasional + $pengeluaran_total_transportasi + $pengeluaran_total_gaji);

        $pengeluaran = Pengeluaran::updateOrCreate([
            'pengeluaran_id' => $request->pengeluaran_id
        ], [
            'pengeluaran_tanggal'            => $request->pengeluaran_tanggal,
            'pengeluaran_tanggal_awal'       => $request->pengeluaran_tanggal_awal,
            'pengeluaran_tanggal_akhir'      => $request->pengeluaran_tanggal_akhir,
            'pengeluaran_total_modal'        => $pengeluaran_total_modal,
            'pengeluaran_total_operasional'  => $pengeluaran_total_operasional,
            'pengeluaran_total_transportasi' => $pengeluaran_total_transportasi,
            'pengeluaran_total_gaji'         => $pengeluaran_total_gaji,
            'pengeluaran_total'              => $pengeluaran_total,
            'pengeluaran_sisa_saldo'         => $pengeluaran_sisa_saldo,
            'user_id'                        => Auth::user()->user_id
        ]);

        // INSERT INTO MODAL
        if (count($request->modal_total) != null) {
            for ($x = 0; $x < count($request->modal_total); $x++) {
                $modal = OutModal::updateOrCreate([
                    'modal_id'   => $request->modal_id,
                ], [
                    'pengeluaran_id'    => $pengeluaran->pengeluaran_id,
                    'modal_keterangan'  => $request->modal_keterangan[$x],
                    'modal_total'       => $request->modal_total[$x],
                ]);
            }
        }

        // INSERT INTO OPERASIONAL
        if (count($request->operasional_total) != null) {

            foreach ($request->operasional_keterangan as $x => $keterangan) {

                $operasional_bukti = $request->file('operasional_bukti')[$x] ?? null;

                if ($operasional_bukti && $operasional_bukti->isValid()) {
                    $bukti_operasional = 'bukti_operasional-' . rand(1, 100000) . '.' . $operasional_bukti->getClientOriginalExtension();

                    // Store the original image
                    $path = Storage::putFileAs('public/bukti_operasional', $operasional_bukti, $bukti_operasional);

                    $operasional = OutOperasional::updateOrCreate([
                        'operasional_id'  => $request->operasional_id,
                    ], [
                        'pengeluaran_id'         => $pengeluaran->pengeluaran_id,
                        'operasional_keterangan' => $keterangan,
                        'operasional_total'      => $request->operasional_total[$x],
                        'operasional_bukti'      => $bukti_operasional,
                        'status'                 => 'mks',
                    ]);
                } else {
                    $operasional = OutOperasional::updateOrCreate([
                        'operasional_id'  => $request->operasional_id,
                    ], [
                        'pengeluaran_id'         => $pengeluaran->pengeluaran_id,
                        'operasional_keterangan' => $keterangan,
                        'operasional_total'      => $request->operasional_total[$x],
                        'operasional_bukti'      => '-',
                        'status'                 => 'mks',
                    ]);
                }
            }
        }

        // INSERT INTO GAJI
        if (count($request->gaji_total) != null) {

            foreach ($request->gaji_keterangan as $x => $keterangan) {
                $gaji_bukti = $request->file('gaji_bukti')[$x] ?? null;

                if ($gaji_bukti && $gaji_bukti->isValid()) {
                    $bukti_gaji = 'bukti_gaji-' . rand(1, 100000) . '.' . $gaji_bukti->getClientOriginalExtension();

                    // Store the original image
                    $path = Storage::putFileAs('public/bukti_gaji', $gaji_bukti, $bukti_gaji);

                    $gaji = OutGaji::updateOrCreate([
                        'gaji_id'  => $request->gaji_id,
                    ], [
                        'pengeluaran_id'  => $pengeluaran->pengeluaran_id,
                        'gaji_keterangan' => $keterangan,
                        'gaji_total'      => $request->gaji_total[$x],
                        'gaji_bukti'      => $bukti_gaji,
                        'status'          => 'mks',
                    ]);
                } else {
                    $gaji = OutGaji::updateOrCreate([
                        'gaji_id'  => $request->gaji_id,
                    ], [
                        'pengeluaran_id'  => $pengeluaran->pengeluaran_id,
                        'gaji_keterangan' => $keterangan,
                        'gaji_total'      => $request->gaji_total[$x],
                        'gaji_bukti'      => '-',
                        'status'          => 'mks',
                    ]);
                }
            }
        }

        // INSERT INTO TRANSPORTASI
        if (count($request->transportasi_total) != null) {

            foreach ($request->transportasi_keterangan as $x => $keterangan) {
                $transportasi_bukti = $request->file('transportasi_bukti')[$x] ?? null;

                if ($transportasi_bukti && $transportasi_bukti->isValid()) {
                    $bukti_transportasi = 'bukti_transportasi-' . rand(1, 100000) . '.' . $transportasi_bukti->getClientOriginalExtension();

                    // Store the original image
                    $path = Storage::putFileAs('public/bukti_transportasi', $transportasi_bukti, $bukti_transportasi);

                    $transportasi = OutTransportasi::updateOrCreate([
                        'transportasi_id'  => $request->transportasi_id,
                    ], [
                        'pengeluaran_id'          => $pengeluaran->pengeluaran_id,
                        'transportasi_keterangan' => $keterangan,
                        'transportasi_total'      => $request->transportasi_total[$x],
                        'transportasi_bukti'      => $bukti_transportasi,
                        'status'                  => 'mks'
                    ]);
                } else {
                    $transportasi = OutTransportasi::updateOrCreate([
                        'transportasi_id'  => $request->transportasi_id,
                    ], [
                        'pengeluaran_id'          => $pengeluaran->pengeluaran_id,
                        'transportasi_keterangan' => $keterangan,
                        'transportasi_total'      => $request->transportasi_total[$x],
                        'status'                  => 'mks',
                        'transportasi_bukti'      => '-',
                    ]);
                }
            }
        }

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Anda telah berhasil disimpan!',
        ]);
    }

    // PENGELUARAN DETAIL
    public function pengeluaranDetail(Request $request)
    {
        $pengeluaran    = Pengeluaran::with(['modal', 'transportasi', 'operasional', 'gaji'])->where('pengeluaran_id', $request->pengeluaran_id)->first();

        return response()->json($pengeluaran);
    }

    // PENGELUARAN PRINT
    public function getPengeluaranData(Request $request)
    {
        $pengeluarans = Pengeluaran::with(['modal', 'operasional', 'gaji', 'transportasi'])
            ->whereBetween('pengeluaran_tanggal', [$request->pengeluaran_tanggal_awal, $request->pengeluaran_tanggal_akhir])
            ->get();

        $total      = $pengeluarans->sum('pengeluaran_total');
        $sisa_saldo = $pengeluarans->sum('pengeluaran_sisa_saldo');

        // If all pengeluarans have valid order_status, return them as JSON
        return response()->json([
            'data'       => $pengeluarans,
            'total'      => $total,
            'sisa_saldo' => $sisa_saldo,
        ]);
    }

    // PENGELUARAN PRINT
    public function pengeluaranPrint(Request $request)
    {
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $pengeluarans = Pengeluaran::with(['modal', 'operasional', 'gaji', 'transportasi'])->whereBetween('pengeluaran_tanggal', [$tanggal_awal, $tanggal_akhir])->get();

        $total          = $pengeluarans->sum('pengeluaran_total');
        $total_modal    = $pengeluarans->sum('pengeluaran_total_modal');
        $sisa_saldo     = $pengeluarans->sum('pengeluaran_sisa_saldo');

        $data[] = [
            'pengeluaran'   => $pengeluarans,
            'total'         => $total,
            'total_modal'   => $total_modal,
            'sisa_saldo'    => $sisa_saldo,
        ];

        // Load the HTML view with the data
        $html = view('layout-print.pengeluaranPrint', ['data' => $data])->render();

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
            ->header('Content-Disposition', 'inline; filename="Pengeluaran-' . $request->pengeluaran_tanggal_awal . '-' . $request->pengeluaran_tanggal_awal . '.pdf"');
        // If you want to save the PDF to a file, use the following line instead:
        // return $dompdf->output()
    }

    // PENGELUARAN DESTROY
    public function pengeluaranDestory(Request $request)
    {
        $pengeluaran = Pengeluaran::find($request->pengeluaran_id);

        if (!$pengeluaran) {
            return response()->json(['error' => 'Pengeluaran not found.'], 404);
        }

        // Use relationships to delete related records
        $pengeluaran->gaji()->delete();
        $pengeluaran->transportasi()->delete();
        $pengeluaran->operasional()->delete();
        $pengeluaran->modal()->delete();

        // Delete the main record
        $pengeluaran->delete();

        // Return a success message or perform any other action after the updates
        return response()->json(['status' => 'Pengeluaran Berhasil di Hapus!']);
    }
}
