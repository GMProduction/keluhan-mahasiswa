<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register()
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
            $access_token = $this->generateTokenById($user->id, "member");
            DB::commit();
            return $this->jsonResponse('success', 200, [
                'access_token' => $access_token,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('terjadi kesalahan ' . $e->getMessage(), 500);
        }
    }

    public function login()
    {
        $credentials = request(['username', 'password']);
        if (!$token = auth('api')->setTTL(null)->attempt($credentials)) {
            return $this->jsonResponse('Username dan Password Tidak Cocok', 401);
        }
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return $this->jsonResponse('success', 200, [
            'access_token' => $token,
            'type' => 'Bearer'
        ]);
    }

}
