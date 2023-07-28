<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    // INDEX USER
    public function orderIndex(Request $request)
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
}
