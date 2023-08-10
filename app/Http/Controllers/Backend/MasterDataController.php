<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kadar;
use App\Models\Merk;
use App\Models\ModelBarang;
use App\Models\Order;
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

        $sumOfPendingOrders = Order::whereHas('payment', function ($query) {
            $query->where('payment_status', 'blm-lunas');
        })->sum('order_total');

        $sumOfPiutangSurabaya = Order::whereHas('payment', function ($query) {
            $query->where('payment_status', 'blm-lunas')->where('payment_method', 'bayar-surabaya');
        })->sum('order_total');

        $sumOfPiutangMakassar = Order::whereHas('payment', function ($query) {
            $query->where('payment_status', 'blm-lunas')->where('payment_method', 'bayar-makassar');
        })->sum('order_total');

        $sumOfSettleOrders = Order::whereHas('payment', function ($query) {
            $query->where('payment_status', 'lunas');
        })->sum('order_total');

        $sumOfTotalOrder = Order::sum('order_total');

        $data = [
            'pendingOrder'    => $sumOfPendingOrders,
            'settleOrder'     => $sumOfSettleOrders,
            'piutangSurabaya' => $sumOfPiutangSurabaya,
            'piutangMakassar' => $sumOfPiutangMakassar,
            'totalOrder'      => $sumOfTotalOrder,
        ];

        return view('dashboard', compact('data', 'filterMonth', 'filterYear'));
    }

    public function filter(Request $request)
    {
        $filterMonth = $request->input('month'); // Get the selected month from the request
        $filterYear = $request->input('year');   // Get the selected year from the request

        $orders = Order::with('payment')->whereYear('order_tanggal', $filterYear)->whereMonth('order_tanggal', $filterMonth)->get();

        $sumOfPendingOrders   = $orders->where('payment.payment_status', 'blm-lunas')->sum('order_total');
        $sumOfSettleOrders    = $orders->where('payment.payment_status', 'lunas')->sum('order_total');
        $sumOfPiutangSurabaya = $orders->where('payment.payment_status', 'blm-lunas')->where('payment.payment_method', 'bayar-surabaya')->sum('order_total');
        $sumOfPiutangMakassar = $orders->where('payment.payment_status', 'blm-lunas')->where('payment.payment_method', 'bayar-makassar')->sum('order_total');
        $sumOfTotalOrder      = $orders->sum('order_total');

        $data = [
            'pendingOrder'    => $sumOfPendingOrders,
            'settleOrder'     => $sumOfSettleOrders,
            'piutangSurabaya' => $sumOfPiutangSurabaya,
            'piutangMakassar' => $sumOfPiutangMakassar,
            'totalOrder'      => $sumOfTotalOrder,
        ];

        return response()->json($data); // Return data directly without 'data' key
    }



    public function resetFilter()
    {
        $sumOfPendingOrders = Order::whereHas('payment', function ($query) {
            $query->where('payment_status', 'blm-lunas');
        })->sum('order_total');

        $sumOfPiutangSurabaya = Order::whereHas('payment', function ($query) {
            $query->where('payment_status', 'blm-lunas')->where('payment_method', 'bayar-surabaya');
        })->sum('order_total');

        $sumOfPiutangMakassar = Order::whereHas('payment', function ($query) {
            $query->where('payment_status', 'blm-lunas')->where('payment_method', 'bayar-makassar');
        })->sum('order_total');

        $sumOfSettleOrders = Order::whereHas('payment', function ($query) {
            $query->where('payment_status', 'lunas');
        })->sum('order_total');

        $sumOfTotalOrder = Order::sum('order_total');

        $data = [
            'pendingOrder'    => $sumOfPendingOrders,
            'settleOrder'     => $sumOfSettleOrders,
            'piutangSurabaya' => $sumOfPiutangSurabaya,
            'piutangMakassar' => $sumOfPiutangMakassar,
            'totalOrder'      => $sumOfTotalOrder,
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
            'message' => 'Your data has been saved successfully!',
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

        return response()->json(['status' => 'Data Deleted Successfully!']);
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
