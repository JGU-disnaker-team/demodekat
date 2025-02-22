<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\Order;
use App\Models\Layanan;
use Illuminate\Http\Request;
use App\DataTables\KontakDataTable;
use App\DataTables\MemberDataTable;
use Laravolt\Indonesia\Models\City;
use Illuminate\Support\Facades\Auth;
use Laravolt\Indonesia\Models\Village;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function profil()
    {
        $data = Auth::user();
        $provinces = province::all();
        return view('frontend.profil', compact('data', 'provinces'));
    }


    public function update_profil(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',

        ]);

        $data = User::where('id', Auth::user()->id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->name = $request->name;
        $data->email = $request->email;
        if (!empty($request->password)) {
            $data->password = bcrypt($request->password);
        }
        $data->no_telp = $request->no_telp;
        $data->province_code = $request->province_code;
        $data->city_code = $request->city_code;
        $data->district_code = $request->district_code;
        $data->village_code = $request->village_code;
        $data->alamat = $request->alamat;
        $data->no_rekening = $request->no_rekening;
        $data->rt = $request->rt;
        $data->rw = $request->rw;

        $fileimage = $request->file('image');
        if (!empty($fileimage)) {
            $fileimageName = date('dHis') . '.' . $fileimage->getClientOriginalExtension();
            Storage::putFileAs(
                'public/user',
                $fileimage,
                $fileimageName
            );

            $data->avatar = $fileimageName;
        }
        $data->update();
        Session::flash('success', 'data berhasil di simpan');
        return redirect('profil');
    }
    public function getCities($province_code)
    {
        try {
            $cities = City::where('province_code', $province_code)->get();
            return response()->json($cities);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getDistricts($city_code)
    {
        try {
            $districts = District::where('city_code', $city_code)->get();
            return response()->json($districts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getVillages($district_code)
    {
        try {
            $villages = Village::where('district_code', $district_code)->get();
            return response()->json($villages);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function member(MemberDataTable $dataTable)
    {
        return $dataTable->render('data.user.member.index');
    }

    public function kontak(KontakDataTable $dataTable)
    {
        return $dataTable->render('data.kontak.index');
    }

    public function pesan($id)
    {
        $data = Layanan::with('kategori')->where('status', 1)->where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        return view('frontend.pesan', compact('data'));
    }

    public function send_order(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'layanan_id' => 'required|exists:layanans,id',
            'waktu' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }
        $requestDate = $request->waktu; // Assume this is in 'Y-m-d' format
        $serviceTime = $request->jam;  // Assume this is in 'H:i:s' format

        // Combine the date and time
        $combinedDateTime = $requestDate . ' ' . $serviceTime;

        // Parse the combined date and time
        $dateTime = new DateTime($combinedDateTime);

        $layanan = Layanan::find($request->layanan_id);

        $order = new Order();
        $order->layanan_id = $request->layanan_id;
        $order->customer_id = Auth::user()->id;
        $order->harga_member = $layanan->harga_member;
        $order->harga_worker = $layanan->harga_worker;
        $order->nominal = $layanan->harga_member + rand(100, 999);
        $order->waktu = $dateTime;
        $order->alamat = $request->alamat;
        $order->status_pembayaran = 1;
        $order->status_order = 1;
        $order->save();

        return redirect('data/order/' . $order->id . '/success_order')->with('success', 'order berhasil di buat');
    }
}
