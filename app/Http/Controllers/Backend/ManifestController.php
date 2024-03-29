<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Manifest;
use App\Models\ManifestDetail;
use App\Models\Order;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ManifestController extends Controller
{
    public function manifestIndex(Request $request)
    {
        $manifest     = Manifest::with(['detailmanifest'])->get();

        if ($request->ajax()) {
            $manifests   = Manifest::with(['detailmanifest'])->latest()->get();
            return DataTables::of($manifests)
                ->addIndexColumn()
                ->addColumn('manifest_no', function ($item) {
                    return $item->manifest_no;
                })
                ->addColumn('manifest_tanggal', function ($item) {
                    return $item->manifest_tanggal;
                })
                ->addColumn('manifest_plat_mobil', function ($item) {
                    return $item->manifest_plat_mobil;
                })
                ->addColumn('manifest_total_koli', function ($item) {

                    $manifest = Manifest::with(['detailmanifest.order.payment'])->where('manifest_id', $item->manifest_id)->first();

                    $sumOrderKoli = $manifest->detailmanifest->sum(function ($detail) {
                        return $detail->order->order_koli;
                    });

                    // return $item->manifest_total_koli;
                    return $sumOrderKoli;
                })
                ->addColumn('manifest_total_berat', function ($item) {

                    $manifest = Manifest::with(['detailmanifest.order.payment'])->where('manifest_id', $item->manifest_id)->first();

                    $sumOrderBerat = $manifest->detailmanifest->sum(function ($detail) {
                        return $detail->order->order_berat;
                    });

                    $sumOrderVolume = $manifest->detailmanifest->sum(function ($detail) {
                        return $detail->order->order_volume;
                    });

                    // return $item->manifest_total_berat . 'Kg';
                    return $sumOrderBerat + $sumOrderVolume;
                })
                ->addColumn('manifest_total_harga', function ($item) {

                    $manifest = Manifest::with(['detailmanifest.order.payment'])->where('manifest_id', $item->manifest_id)->first();
                    
                    $sumOrderTotal = $manifest->detailmanifest->sum(function ($detail) {
                        return $detail->order->order_total;
                    });

                    // return 'Rp. ' . number_format($item->manifest_total_harga);
                    return 'Rp. ' . number_format($sumOrderTotal);
                })
                ->addColumn('action', function ($item) {

                    $btn = '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="manifest-print" title="PRINT MANIFEST" data-id="' . $item->manifest_id . '"><span class="material-icons btn-sm">print</span></button>';

                    $btn = $btn . '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="detail-manifest" title="DETAIL MANIFEST" data-id="' . $item->manifest_id . '"><span class="material-icons btn-sm">visibility</span></button>';

                    // Checking Role to Access it.
                    if (Auth::user()->city == 'surabaya' || Auth::user()->role == 'superadmin') {
                        // $btn = $btn . '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="manifest-edit" title="EDIT MANIFEST" data-id="' . $item->manifest_id . '"><span class="material-icons btn-sm">edit</span></button>';
                        $btn = $btn . '<button class="btn btn-icon btn-primary btn-rounded flush-soft-hover me-1" id="manifest-delete" title="DELETE MANIFEST" data-id="' . $item->manifest_id . '"><span class="material-icons btn-sm">delete</span></button>';
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('transaksi.data-manifest', compact('manifest'));
    }

    // GET DATA BY MANIFEST ID
    public function getdata(Request $request)
    {
        $manifest = Manifest::with(['detailmanifest'])->where('manifest_id', $request->manifest_id)->first();

        return response()->json($manifest);
    }



    // GET DATA ORDER BEFORE MAKE A NEW DATA MANIFEST
    public function getorderdata(Request $request)
    {
        // $orders = Order::whereBetween('order_tanggal', [$request->manifest_tanggal_awal, $request->manifest_tanggal_akhir])->get();

        // // Check the order_status for each order
        // $manifestOrders = [];
        // foreach ($orders as $order) {
        //     if ($order->order_status == 'on-progress' || $order->order_status == 'telah-sampai') {
        //         // If order_status is 'manifest', return an error response with an HTTP error code
        //         return response(['error' => 'Orders tidak dapat di proses.']);
        //     } else {
        //         // If order_status is not 'manifest', add it to the manifestOrders array
        //         $manifestOrders[] = $order;
        //     }
        // }
        if ($request->data) {
            // // If all orders have valid order_status, return them as JSON
            // return response()->json($manifestOrders);
            $orders = Order::whereBetween('order_tanggal', [$request->manifest_tanggal_awal, $request->manifest_tanggal_akhir])->get();
        } else {
            // // If all orders have valid order_status, return them as JSON
            // return response()->json($manifestOrders);
            $orders = Order::whereBetween('order_tanggal', [$request->manifest_tanggal_awal, $request->manifest_tanggal_akhir])
                ->where('order_status', 'terdaftar')
                ->get();
        }

        // Return the filtered orders as JSON
        return response()->json($orders);
    }

    // GET ORDER DATA TO UPDATE MANIFEST
    public function manifestedit(Request $request)
    {
    }

    // STORED DATA MANIFEST BARU
    public function manifestStore(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'manifest_tanggal'                => 'required',
            'manifest_tanggal_awal'           => 'required|date',
            'manifest_tanggal_akhir'          => 'required|date|after_or_equal:manifest_tanggal_awal',
            'manifest_plat_mobil'             => 'required',
        ], [
            'manifest_tanggal.required'             => 'Manifest Tanggal Harus di Isi!',
            'manifest_tanggal_awal.required'        => 'Tanggal Awal Manifest Harus di Isi!',
            'manifest_tanggal_akhir.required'       => 'Tanggal Akhir Manifest Harus di Isi!',
            'manifest_tanggal_akhir.after_or_equal' => 'Tanggal Akhir Manifest Harus Sama atau di Atas Tanggal Awal!',
            'manifest_plat_mobil.required'          => 'Plat Mobil Harus di Isi!',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // // Define the model name
        // $modelName = 'DataManifest';

        // // Get the current date and time
        // $currentTime = Carbon::createFromFormat('Y-m-d', $request->manifest_tanggal);

        // // Get the formatted date portion (yymm)
        // $datePart = $currentTime->format('y');

        // // Get the current counter value from cache for the specific model
        // $counter = Cache::get($modelName . '_counter');

        // // Increment the counter
        // $counter++;

        // // Check if the counter reaches 999, then reset it
        // if ($counter > 999) {
        //     $counter = 1;
        // }

        // // Store the updated counter and date in the cache
        // Cache::put($modelName . '_counter', $counter);
        // Cache::put($modelName . '_counter_date', $datePart);

        // // Generate the new ID
        // $newId = 'M' . $datePart . sprintf(
        //     "%03d",
        //     $counter
        // );

        // Define the model name
        $modelName = 'DataManifest';

        // Get the current date and time
        $currentTime = Carbon::createFromFormat('Y-m-d', $request->manifest_tanggal);

        // Get the formatted date portion (yymm)
        $datePart = $currentTime->format('y');

        // Find the latest entry in the database
        $latestEntry = Manifest::latest()->first();

        // If there are no entries, start the counter at 1, otherwise extract the counter from the latest entry
        $counter = $latestEntry ? intval(substr($latestEntry->manifest_no, -3)) + 1 : 1;

        // Check if the counter reaches 999, then reset it
        if ($counter > 999) {
            $counter = 1;
        }

        // Generate the new ID
        $newId = 'M' . $datePart . sprintf(
            "%03d",
            $counter
        );

        // SUM EACH ROW NEED TO BE STORE FOR MANIFEST
        $orders = Order::whereIn('order_id', $request->order_id)->get();
        $order_total_koli   = $orders->sum('order_koli');
        $order_total_berat  = $orders->sum('order_berat');
        $order_total_volume = $orders->sum('order_volume');
        $order_total        = $orders->sum('order_total');

        // Store data manifest
        $manifest   = Manifest::updateOrCreate([
            'manifest_id'             => $request->manifest_id,
        ], [
            'manifest_no'             => $newId,
            'manifest_tanggal'        => $request->manifest_tanggal,
            'manifest_tanggal_awal'   => $request->manifest_tanggal_awal,
            'manifest_tanggal_akhir'  => $request->manifest_tanggal_akhir,
            'manifest_plat_mobil'     => $request->manifest_plat_mobil,
            'manifest_total_koli'     => $order_total_koli,
            'manifest_total_berat'    => $order_total_berat,
            'manifest_total_volume'   => $order_total_volume,
            'manifest_total_harga'    => $order_total,
        ]);

        // store to detail manifest
        for ($x = 0; $x < count($request->order_id); $x++) {

            $detail_manifest = ManifestDetail::updateOrCreate([
                'detail_manifest_id'    => $request->detail_manifest_id,
            ], [
                'manifest_id'           => $manifest->manifest_id,
                'order_id'              => $request->order_id[$x],
                'ket'                   => $request->ket[$x],
            ]);

            // update order_status to manifested
            $order = Order::where('order_id', $request->order_id[$x]);
            $order->update(['order_status' => 'on-progress']);
        }

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Anda telah berhasil disimpan!',
        ]);
    }

    // DETAIL MANIFEST
    public function manifestDetail(Request $request)
    {
        $manifest = Manifest::with(['detailmanifest.order.payment'])->where('manifest_id', $request->manifest_id)->first();

        if ($manifest) {
            // Access the related orders using dot notation and use the sum() function
            $sumOfTotalPay = $manifest->detailmanifest->sum(function ($detail) {
                // Check if the payment_status is "blm-lunas" before adding to the sum
                if ($detail->order->payment->payment_status === 'blm-lunas') {
                    return $detail->order->order_total;
                } else {
                    return 0; // Return 0 for orders with payment_status other than "blm-lunas"
                }
            });

            $sumOrderTotal = $manifest->detailmanifest->sum(function ($detail) {
                return $detail->order->order_total;
            });

            $sumOrderBerat = $manifest->detailmanifest->sum(function ($detail) {
                return $detail->order->order_berat;
            });

            $sumOrderKoli = $manifest->detailmanifest->sum(function ($detail) {
                return $detail->order->order_koli;
            });

            $sumOrderVolume = $manifest->detailmanifest->sum(function ($detail) {
                return $detail->order->order_volume;
            });

            return response()->json([
                'manifest'       => $manifest, 
                'sumOrderTotal'  => $sumOrderTotal, 
                'sumOfTotalPay'  => $sumOfTotalPay,
                'sumOrderBerat'  => $sumOrderBerat,
                'sumOrderKoli'   => $sumOrderKoli,
                'sumOrderVolume' => $sumOrderVolume,
            ]);

        } else {
            return response()->json(['error' => 'Manifest not found'], 404);
        }
    }

    // UPDATE STATUS MANIFEST
    public function manifestUpdateStatus(Request $request)
    {
        $manifest = Manifest::with(['detailmanifest.order'])->where('manifest_id', $request->manifest_id)->first();

        if ($manifest) {
            foreach ($manifest->detailmanifest as $detail) {
                $order = $detail->order;
                // dd($order);
                $order->update(['order_status' => 'delivered']);
            }

            // If you want to update the order_status for the orders without loading the relationships, you can use a separate query:
            // Order::whereIn('id', $manifest->detailmanifest->pluck('order_id'))->update(['order_status' => 'delivered']);

            // // Now you can also update the manifest status itself if needed
            $manifest->update(['manifest_status' => 'delivered']);

            // Return a success message or perform any other action after the updates
            return response()->json(['status' => 'Status pesanan diperbarui menjadi berhasil terkirim']);
        } else {
            return response()->json(['status' => 'Manifes tidak ditemukan'], 404);
        }
    }

    // PRINT MANIFEST
    public function manifestPrint(Request $request)
    {
        // Get the data to be displayed in the PDF
        $manifest = Manifest::with(['detailmanifest.order.payment'])->where('manifest_id', $request->manifest_id)->first();

        // Load the HTML view with the data
        $html = view('layout-print.manifestPrint', ['manifest' => $manifest])->render();

        // Create a new Dompdf instance
        $dompdf = new Dompdf();

        // Load the HTML into Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Set paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Get the PDF content as a string
        $pdfContent = $dompdf->output();

        // Return the PDF content with appropriate headers
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="Manifest-' . $manifest->manifest_no . '.pdf"');
    }

    // MANIFEST DELETE
    public function manifestDestroy(Request $request)
    {
        $manifest = Manifest::with(['detailmanifest.order'])->where('manifest_id', $request->manifest_id)->first();

        if ($manifest) {
            foreach ($manifest->detailmanifest as $detail) {
                $order = $detail->order;

                $order->update(['order_status' => 'terdaftar']);
            }

            // Now you can also update the manifest status itself if needed
            $manifest->delete();

            foreach ($manifest->detailmanifest as $detail) {
                $detail->delete();
            }

            // Return a success message or perform any other action after the updates
            return response()->json(['status' => 'Manifest Berhasil di Hapus!']);
        } else {
            return response()->json(['status' => 'Manifes tidak ditemukan'], 404);
        }
    }
}
