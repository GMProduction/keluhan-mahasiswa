<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Keluhan;

class DashboardController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function get_data_keluhan()
    {
        try {
            $data = Keluhan::with('user.mahasiswa.kelas.progdi')
                ->where('status', '=', 'menunggu')
                ->get();
            return $this->basicDataTables($data);
        }catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }
}
