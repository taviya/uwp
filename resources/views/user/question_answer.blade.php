@extends('user.layouts.app')

@push('style')
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush

@section('title', 'Question')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 main-content">
            <div class="row">
                <div class="col-sm-12">
                    <button type="button" id="add_user" class="float-right btn btn-primary" data-toggle="modal" data-target=".add_question_ans">Add Question <i class="fas fa-plus"></i></button>
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Category</th>
                                <th width="100px">Status</th>
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
</main>

<div class="modal fade add_question_ans" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="question_form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title" class="col-form-label">Question:</label>
                        <input type="text" data-validation="required" name="question" class="form-control" id="title">
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Category:</label>
                        <select class="form-control" name="category" id="category" data-validation="required">
                            <option value="">---Select Category---</option>
                            @if(!empty($category))
                                @foreach($category as $singleCategory)
                                <option value="{{ $singleCategory->id }}">{{ $singleCategory->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group append-text-aria">
                        <button type="button" class="custom-button btn btn-primary btn-md">Add More Ans</button>
                        <label class="col-form-label">Answer:</label>
                        <textarea name="answer[]" class="form-control" data-validation="required" rows="3"></textarea>
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

<div class="app-txt-aria d-none">
    <textarea name="answer[]" class="form-control" data-validation="required" rows="3"></textarea>
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

        $(".custom-button").click(function() {
            var txt = $('.app-txt-aria').html()
            $(".append-text-aria").append(txt);
        })

        //Show question and answer list
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('question-ans.index') }}",
            columns: [
                { 
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
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#question_form').submit(function(event) {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ route('question-ans.store') }}",
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
                    $('#question_form').css("opacity", ".5");
                },
                success: function(response) {
                    if (response.status) {
                        $(".add_question_ans").modal('hide');
                        message(response.message);
                        $('#question_form')[0].reset();
                        table.ajax.reload();
                    }
                    $('#question_form').css("opacity", "");
                    $(".submitBtn").removeAttr("disabled");
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                },
                error: function(xhr) {
                    $('#question_form').css("opacity", "");
                    $(".submitBtn").removeAttr("disabled");
                    var error = '';
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        error += value + "<br>";
                    });
                    message(error, 'danger');
                }
            });
        });

        $('body').on('click', '.delete-question', function() {
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
                        url: "/question-ans" + '/' + deleteId,
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
    });
</script>

@endpush