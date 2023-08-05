<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PengeluaranController extends Controller
{
    // PENGELUARAN INDEX
    public function pengeluaranIndex(Request $request)
    {
        $pengeluaran     = Pengeluaran::all();

        if ($request->ajax()) {

            $manifests = DB::table('pengeluarans')
                ->select(
                    DB::raw('YEAR(pengeluaran_tanggal) as pengeluaran_year'),
                    DB::raw('MONTH(pengeluaran_tanggal) as pengeluaran_month'),
                    DB::raw('SUM(pengeluaran_total) as total_pengeluaran')
                )
                ->groupBy('pengeluaran_year', 'pengeluaran_month')
                ->orderBy('pengeluaran_year', 'desc')
                ->orderBy('pengeluaran_month', 'desc')
                ->get();

            return DataTables::of($manifests)
                ->addIndexColumn()
                ->addColumn('pengeluaran_month', function ($item) {
                    if ($item->pengeluaran_month == '1') {
                        $month = 'Januari';
                    } else if ($item->pengeluaran_month == '2') {
                        $month = 'Februari';
                    } else if ($item->pengeluaran_month == '3') {
                        $month = 'Maret';
                    } else if ($item->pengeluaran_month == '4') {
                        $month = 'April';
                    } else if ($item->pengeluaran_month == '5') {
                        $month = 'Mei';
                    } else if ($item->pengeluaran_month == '6') {
                        $month = 'Juni';
                    } else if ($item->pengeluaran_month == '7') {
                        $month = 'Juli';
                    } else if ($item->pengeluaran_month == '8') {
                        $month = 'Agustus';
                    } else if ($item->pengeluaran_month == '9') {
                        $month = 'September';
                    } else if ($item->pengeluaran_month == '10') {
                        $month = 'Oktober';
                    } else if ($item->pengeluaran_month == '11') {
                        $month = 'November';
                    } else {
                        $month = 'Desember';
                    }
                    return $month;
                })
                ->addColumn('pengeluaran_year', function ($item) {
                    return $item->pengeluaran_year;
                })
                ->addColumn('total_pengeluaran', function ($item) {
                    return 'Rp.' . number_format($item->total_pengeluaran);
                })
                ->addColumn('action', function ($item) {

                    $btn = '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="pengeluaran-print" title="PRINT PENGELUARAN" data-month="' . $item->pengeluaran_month . '" data-year="' . $item->pengeluaran_year . '" data-total="' . $item->total_pengeluaran . '"><span class="material-icons btn-sm">print</span></button>';

                    $btn = $btn . '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="pengeluaran-detail" title="DETAIL PENGELUARAN" data-month="' . $item->pengeluaran_month . '" data-year="' . $item->pengeluaran_year . '" data-total="' . $item->total_pengeluaran . '"><span class="material-icons btn-sm">visibility</span></button>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('transaksi.data-pengeluaran', compact('pengeluaran'));
    }

    // PENGELUARAN BY DAY
    public function pengeluaranDay(Request $request)
    {
        $pengeluarans   = Pengeluaran::latest()->get();

        $pengeluaran    = [];
        $no       = 1;
        foreach ($pengeluarans as $item) {
            $pengeluaran_id           = $item->pengeluaran_id;
            $pengeluaran_tanggal      = $item->pengeluaran_tanggal;
            $pengeluaran_total        = 'Rp.' . number_format($item->pengeluaran_total);
            $pengeluaran_jenis        = $item->pengeluaran_jenis;
            $pengeluaran_keterangan   = $item->pengeluaran_keterangan;
            $action                   = '<button class="btn btn-icon btn-info btn-rounded flush-soft-hover me-1" id="pengeluaran-edit" data-id="' . $item->pengeluaran_id . '"><span class="material-icons btn-sm">edit</span></button>';

            $action                   .= '<button class="btn btn-icon btn-danger btn-rounded flush-soft-hover me-1" id="pengeluaran-delete" data-id="' . $item->pengeluaran_id . '"><span class="material-icons btn-sm">visibility_off</span></button>';

            $pengeluaran[] = [
                'index'                   => $no++,
                'pengeluaran_id'          => $pengeluaran_id,
                'pengeluaran_tanggal'     => $pengeluaran_tanggal,
                'pengeluaran_total'       => $pengeluaran_total,
                'pengeluaran_jenis'       => $pengeluaran_jenis,
                'pengeluaran_keterangan'  => $pengeluaran_keterangan,
                'action'                  => $action,
            ];
        }

        return DataTables::of($pengeluaran)
            ->rawColumns(['select', 'action']) // Specify the columns containing HTML
            ->toJson();
    }

    // STORED DATA PENGELUARAN
    public function pengeluaranStore(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'pengeluaran_tanggal'              => 'required',
            'pengeluaran_total'                => 'required',
            'pengeluaran_jenis'                => 'required',
            'pengeluaran_keterangan'           => 'required',
        ], [
            'pengeluaran_tanggal.required'     => 'Tanggal Pengeluaran Harus di Isi!',
            'pengeluaran_total.required'       => 'Total Pengeluaran Harus di Isi!',
            'pengeluaran_jenis.required'       => 'Pengeluaran Jenis Harus di Isi!',
            'pengeluaran_keterangan.required'  => 'Pengeluaran Keterangan Harus di Isi!',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // store data pengeluaran
        $pengeluaran = Pengeluaran::updateOrCreate([
            'pengeluaran_id'           => $request->pengeluaran_id,
        ], [
            'pengeluaran_tanggal'      => $request->pengeluaran_tanggal,
            'pengeluaran_total'        => $request->pengeluaran_total,
            'pengeluaran_jenis'        => $request->pengeluaran_jenis,
            'pengeluaran_keterangan'   => $request->pengeluaran_keterangan,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Your data has been saved successfully!',
        ]);
    }

    // EDIT PENGELUARAN
    public function pengeluaranEdit(Request $request)
    {
        $pengeluaran    = Pengeluaran::find($request->pengeluaran_id);

        return response()->json($pengeluaran);
    }

    // DELETE PENGELUARAN
    public function pengeluaranDestroy(Request $request)
    {
        $pengeluaran    = Pengeluaran::find($request->pengeluaran_id)->delete();

        return response()->json(['status' => 'Data Deleted Successfully!']);
    }

    // PRINT PENGELUARAN
    public function pengeluaranDetail(Request $request)
    {
        $pengeluaran = Pengeluaran::whereYear('pengeluaran_tanggal', $request->year)
            ->whereMonth('pengeluaran_tanggal', $request->month)
            ->get();

        return response()->json([
            'data'  => $pengeluaran,
            'month' => $request->month,
            'year'  => $request->year,
            'total' => $request->total,
        ]);
    }

    public function pengeluaranPrint(Request $request)
    {
        $selectedMonth = $request->query('selectedMonth');
        $selectedYear = $request->query('selectedYear');

        // Get the first and last day of the selected month and year
        $firstDayOfMonth = Carbon::create($selectedYear, $selectedMonth, 1)->startOfDay();
        $lastDayOfMonth = Carbon::create($selectedYear, $selectedMonth, 1)->endOfMonth();

        // Get the data for the selected month and year
        $pengeluaran = Pengeluaran::whereBetween('pengeluaran_tanggal', [$firstDayOfMonth, $lastDayOfMonth])->get();

        // Calculate the total sum of pengeluaran_total
        $total = $pengeluaran->sum('pengeluaran_total');

        // Load the HTML view with the data
        $html = view('layout-print.pengeluaranPrint', ['pengeluaran' => $pengeluaran, 'total' => $total])->render();

        // Create a new Dompdf instance
        $dompdf = new Dompdf();

        // Load the HTML into Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'potrait');

        // Render the HTML as PDF
        $dompdf->render();

        if ($request->selectedMonth == '1') {
            $month = 'Januari';
        } else if ($request->selectedMonth == '2') {
            $month = 'Februari';
        } else if ($request->selectedMonth == '3') {
            $month = 'Maret';
        } else if ($request->selectedMonth == '4') {
            $month = 'April';
        } else if ($request->selectedMonth == '5') {
            $month = 'Mei';
        } else if ($request->selectedMonth == '6') {
            $month = 'Juni';
        } else if ($request->selectedMonth == '7') {
            $month = 'Juli';
        } else if ($request->selectedMonth == '8') {
            $month = 'Agustus';
        } else if ($request->selectedMonth == '9') {
            $month = 'September';
        } else if ($request->selectedMonth == '10') {
            $month = 'Oktober';
        } else if ($request->selectedMonth == '11') {
            $month = 'November';
        } else {
            $month = 'Desember';
        }

        // Output the generated PDF to the browser or save it to a file
        return $dompdf->stream('Pengeluaran-' . $month . '-' . $selectedYear . '.pdf');
        // If you want to save the PDF to a file, use the following line instead:
        // return $dompdf->output()
    }
}
