@extends('user.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="sticky-wrapper">
                <nav class="toolbox sticky-header" data-sticky-options="{'mobile': true}">
                    <div class="toolbox-left">
                        <div class="toolbox-item toolbox-sort">
                            <label>Sort By Category:</label>

                            <div class="select-custom">
                                <select name="orderby" class="form-control" id="category-id">
                                    <option value="" selected="selected">--Select Category--</option>
                                    @if(!empty($category))
                                        @foreach($category as $singleCategory)
                                            <option value="{{ $singleCategory->id }}">{{ $singleCategory->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="toolbox-item toolbox-sort">
                            <label>Sort By Date:</label>
                            <div class="select-custom">
                                <input type="date" class="form-control" id="datepicker">
                            </div>
                        </div>

                        <button class="btn btn-danger btn-sm" id="question_filter">Reset</button>
                    </div>
                </nav>
            </div>

            <div class="row">
                <div class="col-lg-12 main-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Question & Ans</th>
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
        <div class="sidebar-overlay"></div>
    </div>
</div>
</main>

@endsection

@push('scripts')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
@endpush

@push('custon-scripts')

<script>
    $(document).ready(function() {
        //Show question and answer list
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
				"url": "{{ route('home') }}",
				"data": function (data) {
					data.category_id = $('#category-id').val();
					data.date = $('#datepicker').val();
				},
			},
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
                }
            ]
        });

        $("#category-id").change(function () {
			table.ajax.reload();
		});

        $('#datepicker').change(function () {
            table.ajax.reload();
        });

        
		/*filter reset reset*/
		$("#question_filter").click(function () {
			$('#category-id').val('').trigger('change');
			$('#datepicker').val('').trigger('change');
			table.search('').columns().search('').draw();
		});
    });
</script>

@endpush