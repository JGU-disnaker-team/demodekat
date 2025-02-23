<?php

namespace App\Http\Controllers\Data;

use App\DataTables\WorkerDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WorkerProof; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class WorkerController extends Controller
{
    // ... method index, create, store tetap sama

    public function index(WorkerDataTable $dataTable)
{
    return $dataTable->render('data.user.worker.index');
}

public function create()
{
    return view('data.user.worker.create'); // Make sure this view exists
}
    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,' . $id,
            'no_telp' => 'required',
            'status' => 'required',
            'arrival_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'work_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'satisfaction_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048'
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
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'status' => $request->status,
            'password' => $request->password ? bcrypt($request->password) : $data->password
        ]);

        // Update gambar profil
        if ($request->hasFile('image')) {
            Storage::delete('public/user/' . $data->avatar);
            $fileimageName = date('dHis') . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/user', $fileimageName);
            $data->avatar = $fileimageName;
            $data->save();
        }

        // Hapus bukti lama dan upload yang baru
        $this->handleProofs($data, $request);

        Session::flash('success', 'Data berhasil diupdate');
        return redirect()->route('worker.index');
    }

    private function handleProofs(User $user, Request $request)
    {
        // Hapus semua bukti lama
        $user->proofs()->each(function($proof) {
            Storage::delete('public/proofs/'.$proof->image_path);
            $proof->delete();
        });

        // Upload bukti baru
        $this->uploadProof($user, 'arrival', $request->file('arrival_proof'));
        $this->uploadProof($user, 'work', $request->file('work_proof'));
        $this->uploadProof($user, 'satisfaction', $request->file('satisfaction_proof'));
    }

    private function uploadProof(User $user, string $type, $file)
    {
        $filename = 'proof_'.$type.'_'.date('YmdHis').'.'.$file->getClientOriginalExtension();

        $file->storeAs('public/proofs', $filename);

        WorkerProof::create([
            'user_id' => $user->id,
            'type' => $type,
            'image_path' => $filename
        ]);
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);

        // Hapus semua bukti
        $data->proofs()->each(function($proof) {
            Storage::delete('public/proofs/'.$proof->image_path);
            $proof->delete();
        });

        $data->delete();
        return response()->json(['success' => 'hapus data berhasil']);
    }
}
