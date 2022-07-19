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
            <table id="table-data" class="display w-100 table table-bordered">
                <thead>
                <tr>
                    <th width="5%" class="text-center">#</th>
                    <th>Tanggal</th>
                    <th>Nama Mahasiswa</th>
                    <th>Kelas</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th width="12%" class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td width="5%" class="text-center">{{ $loop->index + 1 }}</td>
                        <td>{{ $v->tanggal }}</td>
                        <td>{{ $v->user->mahasiswa->nama }}</td>
                        <td>{{ $v->user->mahasiswa->kelas->nama }}</td>
                        <td>{{ $v->deskripsi }}</td>
                        <td>
                            @if($v->gambar !== null)
                                <a target="_blank"
                                   href="{{ $v->gambar }}">
                                    <img
                                        src="{{ $v->gambar }}"
                                        alt="Gambar Keluhan"
                                        style="width: 75px; height: 80px; object-fit: cover"/>
                                </a>
                            @else
                                Tidak Ada Gambar
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="/keluhan-proses/{{ $v->id }}" class="btn btn-sm btn-info btn-edit"
                               data-id="{{ $v->id }}"><i class="fa fa-info"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script type="text/javascript">
        function destroy(id) {
            AjaxPost('/mahasiswa/delete', {id}, function () {
                window.location.reload();
            });
        }

        $(document).ready(function () {
            $('#table-data').DataTable();
            $('.btn-delete').on('click', function (e) {
                e.preventDefault();
                let id = this.dataset.id;
                AlertConfirm('Apakah Anda Yakin?', 'Data yang sudah dihapus tidak dapat di kembalikan', function () {
                    destroy(id);
                })
            });
        });
    </script>
@endsection
