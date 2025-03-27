<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\InHandling;
use App\Models\Kadar;
use App\Models\Merk;
use App\Models\ModelBarang;
use App\Models\Order;
use App\Models\OutGaji;
use App\Models\OutModal;
use App\Models\OutOperasional;
use App\Models\OutTransportasi;
use App\Models\Pabrik;
use App\Models\Pengeluaran;
use App\Models\Supplier;
use App\Models\TransaksiHutang;
use App\Models\TransaksiInOut;
use App\Models\User;
use DateTime;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rules;
use PDO;
use Termwind\Components\Dd;

class MasterDataController extends Controller
{
    // INDEX DASHBOARD
    public function index(Request $request)
    {
        $filterMonth = $request->input('month');
        $filterYear = $request->input('year');

        $sumOfPendingOrders   = Order::whereHas('payment', function ($query) {
            $query->where('payment_status', 'blm-lunas');
        })->sum('order_total');

        $sumOfPiutangSurabaya = Order::whereHas('payment', function ($query) {
            $query->where('payment_status', 'blm-lunas')->where('payment_method', 'bayar-surabaya');
        })->sum('order_total');

        $sumOfPiutangMakassar = Order::whereHas('payment', function ($query) {
            $query->where('payment_status', 'blm-lunas')->where('payment_method', 'bayar-makassar');
        })->sum('order_total');

        $sumOfSettleOrders    = Order::whereHas('payment', function ($query) {
            $query->where('payment_status', 'lunas');
        })->sum('order_total');

        // PENGELUARAN
        $transportasiSby      = OutTransportasi::where('status', 'sby')->get();
        $transportasiMks      = OutTransportasi::where('status', 'mks')->get();
        
        $sumOfTransportSby    = $transportasiSby->sum('transportasi_total');
        $sumOfTransportMks    = $transportasiMks->sum('transportasi_total');

        $operasionalSby       = OutOperasional::where('status', 'sby')->get();
        $operasionalMks       = OutOperasional::where('status', 'mks')->get();

        $sumOfOperasionalSby  = $operasionalSby->sum('operasional_total');
        $sumOfOperasionalMks  = $operasionalMks->sum('operasional_total');

        $gajiSby              = OutGaji::where('status', 'sby')->get();
        $gajiMks              = OutGaji::where('status', 'mks')->get();

        $sumOfGajiSby         = $gajiSby->sum('gaji_total');
        $sumOfGajiMks         = $gajiMks->sum('gaji_total');

        $sumOfModal           = OutModal::sum('modal_total');

        $sumOfTotalPengeluaranSby = $sumOfTransportSby + $sumOfOperasionalSby + $sumOfGajiSby;
        $sumOfTotalPengeluaranMks = $sumOfTransportMks + $sumOfOperasionalMks + $sumOfGajiMks + $sumOfModal;

        // TOTAL HANDLING OVERALL
        $sumOfHandling        = InHandling::sum('handling_total');

        // TOTAL OMSET OVERALL
        $sumOfTotalOrder      = Order::sum('order_total');

        $data = [
            'pendingOrder'      => $sumOfPendingOrders,
            'settleOrder'       => $sumOfSettleOrders,
            'piutangSurabaya'   => $sumOfPiutangSurabaya,
            'piutangMakassar'   => $sumOfPiutangMakassar,
            'pengeluaranSby'    => $sumOfTotalPengeluaranSby,  
            'pengeluaranMks'    => $sumOfTotalPengeluaranMks,
            'totalOrder'        => ($sumOfTotalOrder + $sumOfHandling) - ($sumOfTotalPengeluaranMks + $sumOfTotalPengeluaranSby),
            'totalOrderGlobal'  => $sumOfTotalOrder,
        ];
        
        return view('dashboard', compact('data', 'filterMonth', 'filterYear'));
    }

    // FILTER
    public function filter(Request $request)
    {
        $filterMonth          = $request->input('month'); // Get the selected month from the request
        $filterYear           = $request->input('year');   // Get the selected year from the request

        // GET DATA ORDER BASED ON MONTH AND YEAR
        $orders               = Order::with('payment')->whereYear('order_tanggal', $filterYear)->whereMonth('order_tanggal', $filterMonth)->get();

        $sumOfPendingOrders   = $orders->where('payment.payment_status', 'blm-lunas')->sum('order_total');
        $sumOfSettleOrders    = $orders->where('payment.payment_status', 'lunas')->sum('order_total');
        $sumOfPiutangSurabaya = $orders->where('payment.payment_status', 'blm-lunas')->where('payment.payment_method', 'bayar-surabaya')->sum('order_total');
        $sumOfPiutangMakassar = $orders->where('payment.payment_status', 'blm-lunas')->where('payment.payment_method', 'bayar-makassar')->sum('order_total');
        $sumOfTotalOrder      = $orders->sum('order_total');

        // GET DATA HANDLING BASED ON MONTH AND YEAR
        $handling             = InHandling::whereYear('created_at', $filterYear)->whereMonth('created_at', $filterMonth)->get();
        $sumOfHandling        = $handling->sum('handling_total');

        // GET DATA TRANSPORT OUTCOME BASED ON MONTH AND YEAR
        $transportasiSby      = OutTransportasi::whereYear('created_at', $filterYear)->whereMonth('created_at', $filterMonth)->where('status', 'sby')->get();
        $sumOfTransportSby    = $transportasiSby->sum('transportasi_total');
        
        $transportasiMks      = OutTransportasi::whereYear('created_at', $filterYear)->whereMonth('created_at', $filterMonth)->where('status', 'mks')->get();
        $sumOfTransportMks    = $transportasiMks->sum('transportasi_total');
        
        // GET DATA OPERATIONAL OUTCOME BASED ON MONTH AND YEAR
        $operasionalSby       = OutOperasional::whereYear('created_at', $filterYear)->whereMonth('created_at', $filterMonth)->where('status', 'sby')->get();
        $sumOfOperationalSby  = $operasionalSby->sum('operasional_total');
        
        $operasionalMks       = OutOperasional::whereYear('created_at', $filterYear)->whereMonth('created_at', $filterMonth)->where('status', 'mks')->get();
        $sumOfOperationalMks  = $operasionalMks->sum('operasional_total');

        // GET DATA GAJI OUTCOME BASED ON MONTH AND YEAR
        $gajiSby              = OutGaji::whereYear('created_at', $filterYear)->whereMonth('created_at', $filterMonth)->where('status', 'sby')->get();
        $sumOfGajiSby         = $gajiSby->sum('gaji_total');

        $gajiMks              = OutGaji::whereYear('created_at', $filterYear)->whereMonth('created_at', $filterMonth)->where('status', 'mks')->get();
        $sumOfGajiMks         = $gajiMks->sum('gaji_total');

        // GET DATA MODAL OUTCOME BASED ON MONTH AND YEAR
        $modal             = OutModal::whereYear('created_at', $filterYear)->whereMonth('created_at', $filterMonth)->get();
        $sumOfModal        = $modal->sum('modal_total');

        // TOTAL PENGELUARAN
        $sumOfTotalPengeluaranSby = $sumOfTransportSby + $sumOfOperationalSby + $sumOfGajiSby;
        $sumOfTotalPengeluaranMks = $sumOfTransportMks + $sumOfOperationalMks + $sumOfGajiMks + $sumOfModal;

        $data = [
            'pendingOrder'      => $sumOfPendingOrders,
            'settleOrder'       => $sumOfSettleOrders,
            'piutangSurabaya'   => $sumOfPiutangSurabaya,
            'piutangMakassar'   => $sumOfPiutangMakassar,
            'pengeluaranSby'    => $sumOfTotalPengeluaranSby,
            'pengeluaranMks'    => $sumOfTotalPengeluaranMks,
            'totalOrder'        => ($sumOfTotalOrder + $sumOfHandling) - ($sumOfTotalPengeluaranMks + $sumOfTotalPengeluaranSby),
            'totalOrderGlobal'  => $sumOfTotalOrder,
        ];

        return response()->json($data); // Return data directly without 'data' key
    }

    // RESET FILTER
    public function resetFilter()
    {
        $sumOfPendingOrders   = Order::whereHas('payment', function ($query) {
            $query->where('payment_status', 'blm-lunas');
        })->sum('order_total');

        $sumOfPiutangSurabaya = Order::whereHas('payment', function ($query) {
            $query->where('payment_status', 'blm-lunas')->where('payment_method', 'bayar-surabaya');
        })->sum('order_total');

        $sumOfPiutangMakassar = Order::whereHas('payment', function ($query) {
            $query->where('payment_status', 'blm-lunas')->where('payment_method', 'bayar-makassar');
        })->sum('order_total');

        $sumOfSettleOrders    = Order::whereHas('payment', function ($query) {
            $query->where('payment_status', 'lunas');
        })->sum('order_total');

        // PENGELUARAN
        $transportasiSby      = OutTransportasi::where('status', 'sby')->get();
        $transportasiMks      = OutTransportasi::where('status', 'mks')->get();

        $sumOfTransportSby    = $transportasiSby->sum('transportasi_total');
        $sumOfTransportMks    = $transportasiMks->sum('transportasi_total');

        $operasionalSby       = OutOperasional::where('status', 'sby')->get();
        $operasionalMks       = OutOperasional::where('status', 'mks')->get();

        $sumOfOperasionalSby  = $operasionalSby->sum('operasional_total');
        $sumOfOperasionalMks  = $operasionalMks->sum('operasional_total');

        $gajiSby              = OutGaji::where('status', 'sby')->get();
        $gajiMks              = OutGaji::where('status', 'mks')->get();

        $sumOfGajiSby         = $gajiSby->sum('gaji_total');
        $sumOfGajiMks         = $gajiMks->sum('gaji_total');

        $sumOfModal           = OutModal::sum('modal_total');

        $sumOfTotalPengeluaranSby = $sumOfTransportSby + $sumOfOperasionalSby + $sumOfGajiSby;
        $sumOfTotalPengeluaranMks = $sumOfTransportMks + $sumOfOperasionalMks + $sumOfGajiMks + $sumOfModal;

        // TOTAL HANDLING OVERALL
        $sumOfHandling        = InHandling::sum('handling_total');

        // TOTAL OMSET OVERALL
        $sumOfTotalOrder      = Order::sum('order_total');

        $data = [
            'pendingOrder'      => $sumOfPendingOrders,
            'settleOrder'       => $sumOfSettleOrders,
            'piutangSurabaya'   => $sumOfPiutangSurabaya,
            'piutangMakassar'   => $sumOfPiutangMakassar,
            'pengeluaranSby'    => $sumOfTotalPengeluaranSby,
            'pengeluaranMks'    => $sumOfTotalPengeluaranMks,
            'totalOrder'        => ($sumOfTotalOrder + $sumOfHandling) - ($sumOfTotalPengeluaranMks + $sumOfTotalPengeluaranSby),
            'totalOrderGlobal'  => $sumOfTotalOrder,
        ];

        return response()->json($data);
    }

    // INDEX USER
    public function userIndex(Request $request)
    {
        $users   =   User::all();
        if ($request->ajax()) {
            $users   =   User::all();
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('name', function ($item) {
                    return ucfirst($item->name);
                })
                ->addColumn('email', function ($item) {
                    return $item->email;
                })
                ->addColumn('role', function ($item) {
                    return ucfirst($item->role);
                })
                ->addColumn('city', function ($item) {
                    return ucfirst($item->city);
                })
                ->addColumn('phone_number', function ($item) {
                    return $item->phone_number;
                })
                ->addColumn('action', function ($item) {

                    $btn = '<button class="btn btn-icon btn-info btn-rounded flush-soft-hover me-1" id="user-edit" data-id="' . $item->user_id . '"><span class="material-icons btn-sm">edit</span></button>';

                    $btn = $btn . '<button class="btn btn-icon btn-danger btn-rounded flush-soft-hover me-1" id="user-delete" data-id="' . $item->user_id . '"><span class="material-icons btn-sm">visibility_off</span></button>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('masterdata.data-user', compact('users'));
    }

    // USER STORED DATA
    public function userStore(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'                  => 'required',
            // 'email'              => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'email'                 => 'required|email',
            'role'                  => 'required|in:superadmin,admin',
            'city'                  => 'required|in:surabaya,makassar',
            'phone_number'          => 'required',
            'password'              => 'required|min:8',
            'password_confirmation' => 'required_with:password|same:password'
        ], [
            'name.required'         => 'Nama Harus di Isi!',
            'email.required'        => 'Email Harus di Isi!',
            'phone_number.required' => 'No Handphone Harus di Isi!',
            'role.required'         => 'Posisi Harus di Isi',
            'city.required'         => 'Kota Harus di Isi',
            'password'              => 'Kata Sandi Harus Minimal 8 Karakter',
            'password_confirmation' => 'Konfirmasi Kata Sandi Harus Minimal 8 Karakter',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // insert data to table user 
        $user = User::updateOrCreate([
            'user_id' => $request->user_id
        ], [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'city' => $request->city,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->role);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Anda telah berhasil disimpan!',
        ]);
    }

    // USER EDIT DATA
    public function userEdit(Request $request)
    {
        $user = User::where('user_id', $request->user_id)->first();
        return response()->json($user);
    }

    // USER DELETE DATA
    public function userDestroy(Request $request)
    {
        $user = User::find($request->user_id)->delete();

        return response()->json(['status' => 'Data Berhasil Dihapus!']);
    }

    // INDEX DATA PELANGGAN
    public function customerIndex(Request $request)
    {
        $users   =   User::all();
        if ($request->ajax()) {
            $users   =   User::all();
            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name', function ($item) {
                return ucfirst($item->name);
            })
                ->addColumn('email', function ($item) {
                    return $item->email;
                })
                ->addColumn('role', function ($item) {
                    return ucfirst($item->role);
                })
                ->addColumn('city', function ($item) {
                    return ucfirst($item->city);
                })
                ->addColumn('phone_number', function ($item) {
                    return $item->phone_number;
                })
                ->addColumn('action', function ($item) {

                    $btn = '<button class="btn btn-icon btn-info btn-rounded flush-soft-hover me-1" id="user-edit" data-id="' . $item->user_id . '"><span class="material-icons btn-sm">edit</span></button>';

                    $btn = $btn . '<button class="btn btn-icon btn-danger btn-rounded flush-soft-hover me-1" id="user-delete" data-id="' . $item->user_id . '"><span class="material-icons btn-sm">visibility_off</span></button>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('masterdata.data-pelanggan', compact('users'));
    }
}
