<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Keluhan;

class KeluhanController extends CustomController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Keluhan::with('user.mahasiswa.kelas.progdi')
            ->where('status', '=', 'menunggu')
            ->get();
        return view('admin.keluhan.baru.index')->with(['data' => $data]);
    }

    public function detail($id)
    {
        $data = Keluhan::with('user.mahasiswa.kelas.progdi')
            ->findOrFail($id);
        if ($this->request->method() === 'POST') {
            $status = $this->postField('status');
            $keterangan = $this->postField('keterangan');
            $data->update([
                'status' => $status,
                'keterangan' => $keterangan
            ]);
            return redirect('/keluhan-baru');
        }
        return view('admin.keluhan.baru.detail')->with(['data' => $data]);
    }

    public function proses()
    {
        $data = Keluhan::with('user.mahasiswa.kelas.progdi')
            ->where('status', '=', 'proses')
            ->get();
        return view('admin.keluhan.proses.index')->with(['data' => $data]);
    }

    public function detail_proses($id)
    {
        $data = Keluhan::with('user.mahasiswa.kelas.progdi')
            ->findOrFail($id);
        if ($this->request->method() === 'POST') {
            $data->update([
                'status' => 'selesai'
            ]);
            return redirect('/keluhan-proses');
        }
        return view('admin.keluhan.proses.detail')->with(['data' => $data]);
    }

    public function selesai()
    {
        $data = Keluhan::with('user.mahasiswa.kelas.progdi')
            ->where('status', '!=', 'proses')
            ->where('status', '!=', 'menunggu')
            ->get();
        return view('admin.keluhan.selesai.index')->with(['data' => $data]);
    }

    public function detail_selesai($id)
    {
        $data = Keluhan::with('user.mahasiswa.kelas.progdi')
            ->findOrFail($id);
        return view('admin.keluhan.selesai.detail')->with(['data' => $data]);
    }
}
