@extends('admin.layouts.app')

@push('style')
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('title', 'Question')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Question & Ans</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                    <li class="breadcrumb-item active">Question & Ans</li>
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
                    <div class="card-body">
                        <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered data-table">
                                        <thead>
                                            <tr>
                                                <th>Sr No.</th>
                                                <th>Question</th>
                                                <th>Answer</th>
                                                <th>Category</th>
                                                <th>Added By</th>
                                                <th width="100px">Status</th>
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

        //Show question and answer list
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('question.index') }}",
            columns: [{ 
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex', 
                    orderable: false, 
                    searchable: false 
                },
                {
                    data: 'question',
                    name: 'question'
                },
                {
                    data: 'answer',
                    name: 'answer'
                },
                {
                    data: 'category_id',
                    name: 'category_id'
                },
                {
                    data: 'added_by',
                    name: 'added_by'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        //Question status change
        $(document).on('click', '.status_list', function() {
            $.ajax({
                type: "get",
                url: "{{ route('question.status', '') }}/"+$(this).data('id'),
                data: {},
                success: function(res) {
                    if (res.status) {
                        message(res.message, 'success');
                        table.rows().invalidate('data').draw(false);
                    }
                }
            });
        });
    });
</script>

@endpush