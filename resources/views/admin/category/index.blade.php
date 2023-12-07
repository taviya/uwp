@extends('admin.layouts.app')

@push('style')
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('title', 'Category')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Category</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active">Category</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" id="add_user" class="float-right btn btn-primary" data-toggle="modal" data-target=".category_add">Add Category <i class="fas fa-plus"></i></button>
                    </div>
                    <div class="card-body">
                        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered data-table">
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Category Name</th>
                                                <th width="100px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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
</section>

<div class="modal fade category_add" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="category_form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title" class="col-form-label">Category Name:</label>
                        <input type="text" data-validation="required" name="name" class="form-control" id="title">
                    </div>
                    <div class="form-group">
                        <label for="img" class="col-form-label">Category Images:</label>
                        <input type="file" name="img" data-validation="required mime size" data-validation-allowing="jpg, jpeg, png" data-validation-max-size="2M" class="form-control" id="img">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary submitBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade category_edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="category_edit_form">
                <!-- Ajax Response -->
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
@endpush

@push('custon-scripts')

<script>
    $.validate({
        modules: 'date, security, file',
    });

    $(document).ready(function() {
        var table = $('.data-table').DataTable({
            order: [0, 'desc'],
            ordering: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('category.index') }}",
            columns: [
                { 
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex', 
                    orderable: false, 
                    searchable: false 
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#category_form').submit(function(event) {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ route('category.store') }}",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.submitBtn').attr("disabled", "disabled");
                    $('#category_form').css("opacity", ".5");
                },
                success: function(response) {
                    if (response.status) {
                        $(".category_add").modal('hide');
                        message(response.message);
                        $('#category_form')[0].reset();
                        table.ajax.reload();
                    }
                    $('#category_form').css("opacity", "");
                    $(".submitBtn").removeAttr("disabled");
                },
                error: function(xhr) {
                    $('#category_form').css("opacity", "");
                    $(".submitBtn").removeAttr("disabled");
                    var error = '';
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        error += value + "<br>";
                    });
                    message(error, 'danger');
                }
            });
        });

        $('body').on('click', '.show-category', function() {
            var showId = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: "/admin/category/"+showId+"/edit",
                data: {},
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    
                },
                success: function(response) {
                    $(".category_edit").modal('show');
                    $("#category_edit_form").html(response.data);
                },
                error: function(xhr) {
                    
                }
            });
        });

        $('body').on('click', '.delete-category', function() {
            var deleteId = $(this).data('id');
            Swal.fire({
                title: 'Do you want to delete this record?',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `Don't save`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: "/admin/category"+'/'+deleteId,
                        data: {},
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function() {
                            $('#category_form').css("opacity", ".5");
                        },
                        success: function(response) {
                            if (response.status) {
                                // message(response.message);
                                table.ajax.reload();
                                Swal.fire('Delete!', '', 'success');
                            }
                            $('#category_form').css("opacity", "");
                        },
                        error: function(xhr) {
                            
                        }
                    });
                }
            });
        });

        $('#category_edit_form').submit(function(event) {
            event.preventDefault();
            var editId = $(this).find('input[name="update_id"]').val();
            $.ajax({
                type: 'POST',
                url: "/admin/category/"+editId,
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.submitBtn').attr("disabled", "disabled");
                    $('#category_edit_form').css("opacity", ".5");
                },
                success: function(response) {
                    if (response.status) {
                        $(".category_edit").modal('hide');
                        message(response.message);
                        table.ajax.reload();
                    }
                    $('#category_edit_form').css("opacity", "");
                    $(".submitBtn").removeAttr("disabled");
                },
                error: function(xhr) {
                    $('#category_edit_form').css("opacity", "");
                    $(".submitBtn").removeAttr("disabled");
                    var error = '';
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        error += value + "<br>";
                    });
                    message(error, 'danger');
                }
            });
        });
    });
</script>

@endpush