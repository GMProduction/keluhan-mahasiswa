<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = User::with(['mahasiswa.kelas.progdi'])
            ->where('role', '=', 'mahasiswa')
            ->get();
        return view('admin.pengguna.mahasiswa.index')->with(['data' => $data]);
    }

    public function add_page()
    {
        $kelas = Kelas::all();
        return view('admin.pengguna.mahasiswa.add')->with(['kelas' => $kelas]);
    }

    public function create()
    {
        try {
            DB::beginTransaction();
            $data_user = [
                'username' => $this->postField('username'),
                'password' => Hash::make($this->postField('password')),
                'role' => 'mahasiswa',
            ];
            $user = User::create($data_user);
            $data_siswa = [
                'user_id' => $user->id,
                'kelas_id' => $this->postField('kelas'),
                'nama' => $this->postField('nama'),
                'no_hp' => $this->postField('no_hp'),
                'alamat' => $this->postField('alamat'),
            ];

            Mahasiswa::create($data_siswa);
            DB::commit();
            return redirect()->back()->with(['success' => 'Berhasil Menambahkan Data...']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan ' . $e->getMessage()]);
        }
    }

    public function edit_page($id)
    {
        $data = User::with(['mahasiswa.kelas.progdi'])->findOrFail($id);
        $kelas = Kelas::all();
        return view('admin.pengguna.mahasiswa.edit')->with(['data' => $data, 'kelas' => $kelas]);
    }

    public function patch()
    {
        try {
            DB::beginTransaction();
            $id = $this->postField('id');
            $user = User::with('mahasiswa')->find($id);
            $data = [
                'username' => $this->postField('username'),
            ];
            if ($this->postField('password') !== '') {
                $data['password'] = Hash::make($this->postField('password'));
            }

            $data_siswa = [
                'kelas_id' => $this->postField('kelas'),
                'nama' => $this->postField('nama'),
                'no_hp' => $this->postField('no_hp'),
                'alamat' => $this->postField('alamat'),
            ];
            $user->update($data);
            $user->mahasiswa()->update($data_siswa);
            DB::commit();
            return redirect('/mahasiswa')->with(['success' => 'Berhasil Merubah Data...']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
        }
    }

    public function destroy()
    {
        try {
            DB::beginTransaction();
            $id = $this->postField('id');
            Mahasiswa::where('user_id', $id)->delete();
            User::destroy($id);
            DB::commit();
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('failed', 500);
        }
    }
}
