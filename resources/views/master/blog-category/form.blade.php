<div class="form-group">
    <div class="col-md-10">
        <label for="categoryName">Category Name</label>
        <span class="text-danger font-bolder">*</span>
        <input class="form-control" name="category_name" type="text" id="categoryName"  value="{{ old('category_name', optional($blogCategory)->category_name) }}">

        {!! $errors->first('categoryName', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
   <div class="col-md-10">
       <label for="" class="col-md-4">Status</label>
       <div class="col-md-8">
           <label for=""><input type="radio" name="status" value="1" {{ old('name', optional($blogCategory)->status) == '1' ?'checked':'' }} > Published </label>
           <label for=""><input type="radio" name="status" value="0" {{ old('name', optional($blogCategory)->status) == '0' ?'checked':'' }} > Unpublished </label>
       </div>
   </div>
</div>

