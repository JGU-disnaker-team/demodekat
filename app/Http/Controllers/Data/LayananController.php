<?php

namespace App\Http\Controllers\Data;

use App\DataTables\LayananDataTable;
use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->input('kategori');
        $cari = $request->input('cari');

        $query = Layanan::query();

        if (!empty($kategori)) {
            $query->where('kategori_id', $kategori);
        }

        if (!empty($cari)) {
            $query->where('title', 'like', '%' . $cari . '%');
        }

        $layanan_all = $query->paginate(12);
        $kategori_all = Kategori::all();

        return view('layanan', compact('layanan_all', 'kategori_all', 'kategori', 'cari'));
    }


    public function create()
    {
        return view('data.layanan.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'kategori_id' => 'required',
            'title' => 'required',
            'status' => 'required',
        ]);

        if ($validated->fails()) {
            Session::flash('warning', 'data gagal di simpan');
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        $data = new Layanan();
        $data->kategori_id = $request->kategori_id;
        $data->title = $request->title;
        $data->konten = $request->konten;
        $data->harga_member = $request->harga_member;
        $data->harga_worker = $request->harga_worker;
        $data->featured = $request->featured;
        $data->status = $request->status;
        $fileimage       = $request->file('image');
        if (!empty($fileimage)) {
            $fileimageName   = date('dHis') . '.' . $fileimage->getClientOriginalExtension();
            Storage::putFileAs(
                'public/layanan',
                $fileimage,
                $fileimageName
            );

            $data->image = $fileimageName;
        }
        $data->save();
        Session::flash('success', 'data berhasil di simpan');
        return redirect()->route('layanan.index');
    }

    public function edit($id)
    {
        $data = Layanan::findOrFail($id);
        return view('data.layanan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kategori_id' => 'required',
            'title' => 'required',
            'status' => 'required',
        ]);

        $data = Layanan::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->kategori_id = $request->kategori_id;
        $data->title = $request->title;
        $data->konten = $request->konten;
        $data->harga_member = $request->harga_member;
        $data->harga_worker = $request->harga_worker;
        $data->featured = $request->featured;
        $data->status = $request->status;
        $fileimage       = $request->file('image');
        if (!empty($fileimage)) {
            $fileimageName   = date('dHis') . '.' . $fileimage->getClientOriginalExtension();
            Storage::putFileAs(
                'public/layanan',
                $fileimage,
                $fileimageName
            );

            $data->image = $fileimageName;
        }
        $data->update();
        Session::flash('success', 'data berhasil di simpan');
        return redirect('data/layanan');
    }

    public function destroy($id)
    {
        $data = Layanan::findOrFail($id);
        $data->delete();
        return response()->json(['success' => 'hapus data berhasil']);
    }
}
