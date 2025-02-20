<?php

namespace App\Http\Controllers\Data;

use App\DataTables\LayananDataTable;
use App\DataTables\MemberDataTable;
use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class MemberController extends Controller
{
    public function index(MemberDataTable $dataTable)
    {
        return $dataTable->render('data.user.member.index');
    }

    public function show($id){
        $data = User::role('member')->where('id', $id)->first();
        $this->middleware('verified');
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        return view('data.user.member.show', compact('data'));

    }

    public function destroy($id)
    {
        $data = User::role('member')->where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->delete();
        return response()->json(['success' => 'hapus data berhasil']);
    }
}
