
<div class="form-group">
    <div class="col-md-10">
        <label for="name">Name</label>


            <span class="text-danger font-bolder">*</span>
        <input class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" type="text" id="name" value="{{ old('name', optional($category)->name) }}" minlength="1" maxlength="255" data=" required="true""  placeholder="Enter name here...">

            {!! $errors->first('name', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="category_id">Parent Category</label>


            <select class="" id="category_id" name="category_id">
        	    <option value="" style="display: none;" {{ old('category_id', optional($category)->category_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select category</option>
        	@foreach ($categories as $key => $category)
			    <option value="{{ $key }}" {{ old('category_id', optional($category)->category_id) == $key ? 'selected' : '' }}>
			    	{{ $category }}
			    </option>
			@endforeach
        </select>

            {!! $errors->first('category_id', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

