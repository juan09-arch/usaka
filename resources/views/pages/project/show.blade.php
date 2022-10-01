@extends('layouts.app')

@section('title', 'USAKA | PROJECT')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $project->title }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Project Management</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="alert border-info">
                            <h5>Keterangan</h5>
                            <div>
                                {!! $project->description !!}

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Daftar Gambar Project</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <a href="/dashboard/archive/create/{{ $project->id }}"
                                            class="btn btn-success">
                                            <i class="fas fa-plus"></i> Tambah Gambar
                                        </a>
                                    </div>
                                    <div class="col text-right">
                                        <a href="{{ route('dashboard.archive.trash.document', [$project->id]) }}"
                                            class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>

                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <table id="typeDocumentById" class="table table-bordered table-hover">
                                            {{-- <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 10px">No</th>
                                                    @foreach ($inputFormat as $eachInput)
                                                        <th style="width: auto">{{ $eachInput['name'] }}</th>
                                                    @endforeach
                                                    <th class="d-none">Room</th>
                                                    <th class="d-none">Locker</th>
                                                    <th class="d-none">Rack</th>
                                                    <th class="d-none">Box</th>
                                                    <th>File Document</th>
                                                    <th width="10%" class="text-center">Aksi</th>
                                                </tr>
                                            </thead> --}}
                                            <tbody>
                                                {{-- @foreach ($documentArchive as $i => $eachDocument)
                                                    <tr>
                                                        <td class="text-center">{{ $i + 1 }}</td>
                                                        @foreach ($eachDocument->documentInfos as $eachInfo)
                                                            <td>{{ $eachInfo['value'] }}</td>
                                                        @endforeach
                                                      
                                                        <td class="d-none">{{ $eachDocument->room->name }}</td>
                                                        <td class="d-none">{{ $eachDocument->locker->code }}</td>
                                                        <td class="d-none">{{ $eachDocument->rack->code }}</td>
                                                        <td class="d-none">{{ $eachDocument->box->code }}</td>
                                                        <td class="text-center">
                                                            <a href="/fileDocument/{{ $eachDocument->file }}"
                                                                class="btn btn-info btn-sm" target="_blank">Download</a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('dashboard.archive.edit.document', $eachDocument->id) }}"
                                                                class="btn btn-warning btn-sm">Edit</a>
                                                            <form method="POST" class="d-inline"
                                                                onsubmit="return confirm('Move data to trash?')"
                                                                action="{{ route('dashboard.archive.delete.document', [$eachDocument->id]) }}">
                                                                @csrf
                                                                <input type="hidden" value="DELETE" name="_method">
                                                                <input type="submit" value="Delete"
                                                                    class="btn btn-danger btn-sm">
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach --}}

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

{{-- THIS SCRIPT ONLY RENDER FOR THIS PAGE --}}
@push('script')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- AdminLTE App -->

    <script>
        $(function() {
            $("#typeDocumentById").DataTable({
                "responsive": true,
            })
        });
    </script>
@endpush


{{-- THIS STYLE ONLY RENDER FOR THIS PAGE --}}
@push('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush
