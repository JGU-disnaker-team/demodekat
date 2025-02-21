<?php

namespace App\Http\Controllers\Data;

use App\DataTables\OrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Layanan;
use App\Models\Order;
use App\Models\User;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function index(OrderDataTable $dataTable)
    {        // Render the appropriate DataTable
        return $dataTable->render('data.order.index');
    }

    public function success_order($id)
    {
        $data = Order::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data_bank = Bank::where("status", 1)->orderBy('no_urut', 'asc')->get();
        return view('data.order.success_order', compact('data', 'data_bank'));
    }

    public function konfirmasi($id)
    {
        $data = Order::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data_bank = Bank::where("status", 1)->orderBy('no_urut', 'asc')->get();
        return view('data.order.konfirmasi', compact('data', 'data_bank'));
    }

    public function send_konfirmasi(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'dari_bank' => 'required',
            'bank_id' => 'required|exists:banks,id',
            'nominal_transfer' => 'required',
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validated->fails()) {
            Session::flash('warning', 'data gagal di simpan');
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        $order = Order::where('id', $id)->first();
        if (empty($order)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }

        $order->dari_bank = $request->dari_bank;
        $order->bank_id = $request->bank_id;
        $order->nominal_transfer = $request->nominal_transfer;
        $order->status_pembayaran = 2;
        $fileimage = $request->file('bukti_transfer');
        if (!empty($fileimage)) {
            $fileimageName = date('dHis') . '.' . $fileimage->getClientOriginalExtension();
            Storage::putFileAs(
                'public/bukti_bayar',
                $fileimage,
                $fileimageName
            );

            $order->bukti_transfer = $fileimageName;
        }
        $order->update();

        return redirect('data/order')->with('success', 'data berhasil di simpan');


    }

    public function bayar_diterima($id)
    {
        $data = Order::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->status_pembayaran = 3;
        $data->status_order = 2;
        $data->update();
        return redirect('data/order')->with('success', 'data berhasil di simpan');
    }

    public function terima_pekerjaan($id)
    {
        $data = Order::where('id', $id)->where('status_order', 2)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->worker_id = Auth::user()->id;
        $data->status_order = 3;
        $data->update();
        return redirect('data/order')->with('success', 'data berhasil di simpan');
    }

    public function selesai_pekerjaan($id)
    {
        $data = Order::where('id', $id)->where('status_order', 3)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->status_order = 4;
        $data->update();

        $user = User::where('id', $data->worker_id)->first();
        $user->wallet = $user->wallet + $data->harga_worker;
        $user->update();

        $wallet = new UserWallet();
        $wallet->user_id = $user->id;
        $wallet->type = 1;
        $wallet->nominal = $data->harga_worker;
        $wallet->save();
        return redirect('data/order')->with('success', 'data berhasil di simpan');
    }

    public function bayar_ditolak($id)
    {
        $data = Order::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->status_pembayaran = 1;
        $data->status_order = 1;
        $data->update();
        return redirect('data/order')->with('success', 'data berhasil di simpan');
    }
    public function show($id)
    {
        $data = Order::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        return view('data.order.show', compact('data'));
    }

    public function destroy($id)
    {
        $data = Order::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->delete();
        return response()->json(['success' => 'hapus data berhasil']);
    }
}
