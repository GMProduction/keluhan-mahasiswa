@extends('admin.layout')

@section('css')
@endsection

@section('content')
    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            Swal.fire("Berhasil!", '{{\Illuminate\Support\Facades\Session::get('success')}}', "success")
        </script>
    @endif

    @if (\Illuminate\Support\Facades\Session::has('failed'))
        <script>
            Swal.fire("Gagal", '{{\Illuminate\Support\Facades\Session::get('failed')}}', "error")
        </script>
    @endif
    <div class="container-fluid pt-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Mahasiswa</p>
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="/dashboard">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/mahasiswa">Mahasiswa</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit
                </li>
            </ol>
        </div>
        <div class="w-100 p-2">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6 col-sm-11">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="/mahasiswa/patch">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <div class="w-100 mb-1">
                                    <label for="username" class="form-label">NIS</label>
                                    <input type="text" class="form-control" id="username" placeholder="NIS"
                                           name="username" value="{{ $data->username }}">
                                </div>
                                <div class="w-100 mb-1">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Password"
                                           name="password">
                                </div>
                                <div class="w-100 mb-1">
                                    <label for="nama" class="form-label">Nama Mahaiswa</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Nama Siswa"
                                           name="nama" value="{{ $data->mahasiswa->nama }}">
                                </div>
                                <div class="form-group w-100 mb-1">
                                    <label for="kelas">Kelas</label>
                                    <select class="form-control" id="kelas" name="kelas">
                                        @foreach($kelas as $v)
                                            <option value="{{ $v->id }}" {{ $data->mahasiswa->kelas->id == $v->id ? 'selected' : '' }}>{{ $v->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-100 mb-1">
                                    <label for="no_hp" class="form-label">No. Hp</label>
                                    <input type="number" class="form-control" id="no_hp" placeholder="No. Hp"
                                           name="no_hp" value="{{ $data->mahasiswa->no_hp }}">
                                </div>
                                <div class="w-100 mb-1">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea rows="3" class="form-control" id="alamat"
                                              name="alamat">{{ $data->mahasiswa->alamat }}</textarea>
                                </div>
                                <div class="w-100 mb-2 mt-3 text-right">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection
