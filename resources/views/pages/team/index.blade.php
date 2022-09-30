@extends('layouts.app')

@section('title', 'PSDKP | Team')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

            <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Jenis Dokumen</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="card card-primary">
                            {{-- <div class="card-header">
                                <h3 class="card-title">Jenis Dokumen</h3>
                            </div> --}}
                            <div class="card-body">
                                <a href="{{ route("dashboard.document-type.create") }}" class="btn btn-success btn-sm mb-3">
                                    <i class="bi bi-pen mr-2"></i></i>Buat Format
                                </a>
                                <table id="documentFormatListTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Dokumen</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
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
            let addUserForm = $("form#addUserForm");
            let editUserForm = $("form#editUserForm");

            let documentFormatListTable = $('#documentFormatListTable').DataTable({
                searching: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                pageLength: 10,
                ajax: {
                    url: "{{ route('dashboard.document-type.get.document-type-datatable') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                },
                columns: [{
                        data: 'name',
                        name: 'name',
                        defaultContent: "-"
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        defaultContent: "-",
                        render: function(data, type, row) {
                            return moment(data).format("LLL");
                        }
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        defaultContent: "-",
                        render: function(data, type, row) {
                            return moment(data).format("LLL");
                        }
                    },
                    {
                        render: function(data, type, row) {
                            var editUrl = '{{ route("dashboard.document-type.edit", ":id") }}';
                            editUrl = editUrl.replace(':id', row.id);

                            // <a data-id=${row.id} name="edit" href="${editUrl}"  class="btn btn-success">
                            //         <i class="fas fa-edit"></i>
                            //     </a>
                            return `
                            <div class="form-group">
                                <button data-id=${row.id} name="delete" class="btn btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        `
                        }
                    },

                ],
            });

    


            //delete button action
            $(document).on("click", "table#documentFormatListTable button[name='delete']", function() {
                let id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "klik yes untuk menghapus akun.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('dashboard.document-type.destroy', ['']) }}/${id}`,
                            type: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            dataType: "JSON",
                            success: function(res) {
                                documentFormatListTable.ajax.reload();
                                showNotification(res.message, "success", 3000);
                            },
                            error: function(res) {
                                let data = res.responseJSON;
                                showNotification(data.message, "error", 3000);
                            }
                        })
                    }
                })
            })


            //edit button action
            $(document).on("click", "table#documentFormatListTable button[name='edit']", function() {
                let id = $(this).attr('data-id');

                $.ajax({
                    url: `{{ route('dashboard.user.show', ['']) }}/${id}`,
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    dataType: "JSON",
                    success: function(res) {
                        let data = res.data;
                        editUserModal.find("input[name='name']").val(data.name);
                        editUserModal.find("input[name='username']").val(data.username);
                        editUserModal.find("input[name='password']").val("");
                        editUserModal.find("input[name='password_confirm']").val("");

                        editUserModal.find("select[name='role'] option").each(function() {
                            if (data.roles[0].name == $(this).val()) {
                                $(this).attr("selected", true);
                            } else {
                                $(this).removeAttr("selected");
                            }
                        })
                        editUserModal.modal("toggle");
                        editUserForm.attr("action",
                            `{{ route('dashboard.user.update', ['']) }}/${id}`)
                    }
                });
            });


        });
    </script>
@endpush


{{-- THIS STYLE ONLY RENDER FOR THIS PAGE --}}
@push('style')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush
