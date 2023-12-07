<div class="modal-body">
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="update_id" value="{{ $category->id }}">
    <div class="form-group">
        <label for="title" class="col-form-label">Name:</label>
        <input type="text" data-validation="required" name="name" value="{{ $category->name }}" class="form-control" id="title">
    </div>

    <div class="form-group">
        <label for="img" class="col-form-label">Category Images:</label>
        <input type="file" name="img[]" data-validation="mime size" data-validation-allowing="jpg, jpeg, png" data-validation-max-size="2M" class="form-control" id="img" multiple>
    </div>

    <div class="form-group row">
        <!-- <label class="col-sm-2 col-form-label"></label> -->
        @if(!empty($categoryImages))
        <div class="col-sm-2 img-wrap lastimage">
            <!-- <span class="close">&times;</span> -->
            <img height="100" width="100" src="{{ asset('upload/category/thumbnail/'.$categoryImages) }}" data-id="{{ $categoryImages }}">
        </div>
        @endif
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary submitBtn">Submit</button>
</div>