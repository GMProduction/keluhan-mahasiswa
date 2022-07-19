<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Progdi;

class ProgdiController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Progdi::all();
        return view('admin.data.progdi.index')->with(['data' => $data]);
    }

    public function add_page()
    {
        return view('admin.data.progdi.add');
    }

    public function create()
    {
        try {
            $data = [
                'nama' => $this->postField('nama'),
            ];
            Progdi::create($data);
            return redirect()->back()->with(['success' => 'Berhasil Menambahkan Data...']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan ' . $e->getMessage()]);
        }
    }

    public function edit_page($id)
    {
        $data = Progdi::findOrFail($id);
        return view('admin.data.progdi.edit')->with(['data' => $data]);
    }

    public function patch()
    {
        try {
            $id = $this->postField('id');
            $progdi = Progdi::find($id);
            $data = [
                'nama' => $this->postField('nama'),
            ];
            $progdi->update($data);
            return redirect('/progdi')->with(['success' => 'Berhasil Merubah Data...']);
        }catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
        }
    }

    public function destroy()
    {
        try {
            $id = $this->postField('id');
            Progdi::destroy($id);
            return $this->jsonResponse('success', 200);
        }catch (\Exception $e) {
            return $this->jsonResponse('failed', 500);
        }
    }
}
