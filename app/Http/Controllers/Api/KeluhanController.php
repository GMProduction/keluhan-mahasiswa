<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Keluhan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class KeluhanController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            if ($this->request->method() === 'POST') {
                $data = [
                    'user_id' => Auth::id(),
                    'tanggal' => Carbon::now('Asia/Jakarta'),
                    'status' => 'menunggu',
                    'deskripsi' => $this->postField('deskripsi'),
                ];
                $nama_file = $this->generateImageName('gambar');

                if ($nama_file !== '') {
                    $data['gambar'] = '/gambar/' . $nama_file;
                    $this->uploadImage('gambar', $nama_file, 'gambar');
                }
                Keluhan::create($data);
                $res = $this->push_notif('hai,', 'Coba Push Notif');
                return $this->jsonResponse('success', 200, $res);
            }
            $param = $this->field('param');
            $query = Keluhan::with('user.mahasiswa');
            if ($param === 'selesai') {
                $query->where(function ($q) {
                    $q->where('status', 'selesai')
                        ->orWhere('status', 'tolak');
                });
            } else {
                $query->where(function ($q) {
                    $q->where('status', 'menunggu')
                        ->orWhere('status', 'proses');
                });
            }
            $data = $query->where('user_id', '=', Auth::id())
                ->get();
            return $this->jsonResponse('success', 200, $data);
        } catch (\Exception $e) {
            return $this->jsonResponse('terjadi kesalahan ' . $e->getMessage(), 500);
        }
    }

    public function detail($id)
    {
        try {
            $data = Keluhan::with('user')
                ->where('id', '=', $id)
                ->first();
            if (!$data) {
                return $this->jsonResponse('keluhan tidak di temukan', 202);
            }
            return $this->jsonResponse('success', 200, $data);
        } catch (\Exception $e) {
            return $this->jsonResponse('terjadi kesalahan ' . $e->getMessage(), 500);
        }
    }
}
