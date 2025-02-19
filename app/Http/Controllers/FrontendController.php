<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Kontak;
use App\Models\Layanan;
use App\Models\Slider;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    public function index()
    {
        $slider_all = Slider::where('status', 1)->orderBy('no_urut')->get();
        $kategori_all = Kategori::where('status', 1)->orderBy('no_urut')->get();
        $testimoni_all = Testimoni::where('status', 1)->orderBy('no_urut')->limit(5)->get();
        $layanan_all = Layanan::with('kategori')->where('status', 1)->where('featured', 1)->latest()->limit(12)->get();
        return view('frontend.welcome', compact('slider_all', 'kategori_all', 'layanan_all', 'testimoni_all'));
    }

    public function layanan(Request $request)
    {
        $kategori = $request->kategori;
        $cari = $request->cari;

        $kategori_all = Kategori::where('status', 1)->orderBy('no_urut')->get();

        $query = Layanan::query();
        $query->where('status', 1);
        if (!empty($cari)) {
            $query->where('title', 'like', '%' . $cari . '%');
        }
        if (!empty($kategori)) {
            $query->wherein('kategori_id', $kategori);
        }
        $layanan_all = $query->with('kategori')->latest()->paginate(15);
        return view('frontend.layanan', compact('layanan_all', 'kategori_all', 'kategori', 'cari'));
    }

    public function layanan_detail($id)
    {
        $data = Layanan::with('kategori')->where('status', 1)->where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data_related = Layanan::with('kategori')->where('status', 1)->where('id', '!=', $id)->inRandomOrder()->limit(4)->get();
        return view('frontend.layanan_detail',compact('data','data_related'));
    }

    public function tentang()
    {
        return view('frontend.tentang');
    }

    public function kontak()
    {
        return view('frontend.kontak');
    }

    public function send_kontak(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required',
            'subjek' => 'required',
            'pesan' => 'required',
        ]);

        if ($validated->fails()) {
            Session::flash('warning', 'data gagal di simpan');
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        $data = new Kontak();
        $data->nama = $request->nama;
        $data->email = $request->email;
        $data->pesan = $request->pesan;
        $data->subjek = $request->subjek;
        $data->save();
        return redirect()->back()->with('success', 'Pesan berhasil di kirim');
    }
}
