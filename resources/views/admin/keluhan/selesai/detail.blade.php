@extends('admin.layout')

@section('css')
@endsection

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif
    <div class="container-fluid pt-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Keluhan Mahasiswa</p>
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Keluhan Mahasiswa
                </li>
            </ol>
        </div>
        <div class="w-100 p-2">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-11">
                    <div class="card">
                        <div class="card-body">
                            <div class="w-100 mb-1">
                                <label for="nama" class="form-label">Nama Mahaiswa</label>
                                <input type="text" class="form-control" id="nama" placeholder="Nama Siswa"
                                       name="nama" value="{{ $data->user->mahasiswa->nama }}" readonly="readonly">
                            </div>
                            <div class="w-100 mb-1">
                                <label for="tanggal" class="form-label">Tanggal Keluhan</label>
                                <input type="text" class="form-control" id="tanggal"
                                       name="tanggal" value="{{ $data->tanggal }}" readonly="readonly">
                            </div>
                            <div class="w-100 mb-1">
                                <label for="deskripsi" class="form-label">Isi Keluhan</label>
                                <textarea rows="3" class="form-control" id="deskripsi"
                                          name="deskripsi" readonly="readonly">{{ $data->deskripsi }}</textarea>
                            </div>
                            <div class="w-100 mb-1">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status"
                                       name="status" value="{{ ucwords($data->status) }}" readonly="readonly">
                            </div>
                            <p class="font-weight-bold">Gambar Keluhan</p>
                            <div class="w-100 mb-1 text-center">
                                @if($data->gambar !== null)
                                    <a target="_blank"
                                       href="{{ $data->gambar }}">
                                        <img
                                            src="{{ $data->gambar }}"
                                            alt="Gambar Keluhan"
                                            style="width: 120px; height: 120px; object-fit: cover"/>
                                    </a>
                                @else
                                    <span class="font-weight-bold">Tidak Ada Gambar Keluhan</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script type="text/javascript">


        $(document).ready(function () {
            $('#status').on('change', function () {
                let val = this.value;
                $('#keterangan').val('')
                if (val === 'tolak') {
                    $('#reason').removeClass('d-none')
                    $('#reason').addClass('d-block')
                } else {
                    $('#reason').removeClass('d-block')
                    $('#reason').addClass('d-none')

                }
            })
        });
    </script>
@endsection
