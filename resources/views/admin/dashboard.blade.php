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
            <p class="font-weight-bold mb-0" style="font-size: 20px">Halaman Dashboard</p>
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item active" aria-current="page">Dashboard
                </li>
            </ol>
        </div>

{{--        <div class="w-100 p-2">--}}
{{--            <table id="table-data" class="display w-100 table table-bordered">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th width="5%" class="text-center">#</th>--}}
{{--                    <th>Tanggal</th>--}}
{{--                    <th>Nama Mahasiswa</th>--}}
{{--                    <th>Kelas</th>--}}
{{--                    <th>Deskripsi</th>--}}
{{--                    <th>Gambar</th>--}}
{{--                    <th width="12%" class="text-center">Action</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}
    </div>

@endsection

@section('js')
    <script src="{{ asset('/js/helper.js') }}"></script>
{{--    <script src="{{ asset('/js/FBService.js') }}"></script>--}}
    <script type="text/javascript">
        var table;

        function reload_data() {
            table.ajax.reload();
        }

        $(document).ready(function () {
            // table = DataTableGenerator('#table-data', '/dashboard/data', [
            //     {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false},
            //     {data: 'tanggal'},
            //     {data: 'user.mahasiswa.nama'},
            //     {data: 'user.mahasiswa.kelas.nama'},
            //     {data: 'deskripsi'},
            //     {
            //         data: null, render: function (data) {
            //             if (data['gambar'] === null) {
            //                 return '<span>Tidak Ada Gambar</span>';
            //             }else {
            //                 return '<a target="_blank" href="' + data['gambar'] + '">' +
            //                     '<img src="' + data['gambar'] + '" alt="Gambar Keluhan" style="width: 75px; height: 80px; object-fit: cover"/>' +
            //                     '</a>';
            //             }
            //
            //         }
            //     },
            //     {
            //         data: null, render: function (data) {
            //             return '<a href="/keluhan-baru/' + data['id'] + '" class="btn btn-sm btn-info btn-edit"\n' +
            //                 '                               data-id="' + data['id'] + '"><i class="fa fa-info"></i></a>';
            //         }
            //     },
            // ], [], function (d) {
            // }, {
            //     dom: 'ltipr',
            //     "fnDrawCallback": function (oSettings) {
            //     }
            // });
        });
    </script>
@endsection
