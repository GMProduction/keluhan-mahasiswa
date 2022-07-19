<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Kelas;

class KelasController extends CustomController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $data = Kelas::with('progdi')
                ->get();
            return $this->jsonResponse('success', 200, $data);
        } catch (\Exception $e) {
            return $this->jsonResponse('terjadi kesalahan ' . $e->getMessage(), 500);
        }
    }
}
