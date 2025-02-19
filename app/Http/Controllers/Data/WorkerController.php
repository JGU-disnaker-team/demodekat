<?php

namespace App\Http\Controllers\Data;

use App\DataTables\WorkerDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth; // Tambahkan ini untuk Auth::user()
use Illuminate\Support\Facades\Hash; // Tambahkan ini untuk Hash::check() dan Hash::make()
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class WorkerController extends Controller
{
    public function index(WorkerDataTable $dataTable)
    {
        return $dataTable->render('data.user.worker.index');
    }

    public function create()
    {
        return view('data.user.worker.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'alamat' => 'required', // Tambah validasi alamat
        ]);

        if ($validated->fails()) {
            Session::flash('warning', 'data gagal di simpan');
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->no_telp = $request->no_telp;
        $data->alamat = $request->alamat;
        $data->wallet = $request->wallet;
        $data->status = $request->status;
        $fileimage       = $request->file('image');
        if (!empty($fileimage)) {
            $fileimageName   = date('dHis') . '.' . $fileimage->getClientOriginalExtension();
            Storage::putFileAs(
                'public/user',
                $fileimage,
                $fileimageName
            );

            $data->avatar = $fileimageName;
        }
        $data->save();
        $data->assignRole('worker');
        Session::flash('success', 'data berhasil di simpan');
        return redirect()->route('worker.index');
    }

    public function show($id)
    {
        $data = User::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        return view('data.user.worker.show', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'no_telp' => 'required',
            'alamat' => 'required',
            'status' => 'required',
        ]);

        if ($validated->fails()) {
            return redirect()->back()
                ->withErrors($validated)
                ->withInput()
                ->with('warning', 'Data gagal diupdate');
        }

        $data = User::findOrFail($id);

        // Update data user
        $data->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'status' => $request->status,
            'password' => $request->password ? bcrypt($request->password) : $data->password
        ]);

        // Update gambar
        if ($request->hasFile('image')) {
            Storage::delete('public/user/' . $data->avatar);

            $fileimageName = date('dHis') . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/user', $fileimageName);
            $data->avatar = $fileimageName;
            $data->save();
        }

        Session::flash('success', 'Data berhasil diupdate');
        return redirect()->route('worker.index');
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
        return response()->json(['success' => 'hapus data berhasil']);
    }
}
