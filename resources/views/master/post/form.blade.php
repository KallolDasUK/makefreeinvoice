<div class="form-group">
    <div class="col-md-10">
        <label for="title">Title</label>
        <span class="text-danger font-bolder">*</span>
        <input class="form-control" name="title" type="text" id="title"
               value="{{ old('title', optional($post)->title) }}">

        {!! $errors->first('title', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="category_id">Category</label>


        <select class="form-control searchable" id="category_id" name="category_id">
            <option value=""
                    {{ old('category_id', optional($post)->category_id ?: '') == '' ? 'selected' : '' }}
                    selected>Select category id
            </option>
            @foreach ($categories as $key => $category)
                <option
                    value="{{ $key }}" {{ old('category_id', optional($post)->category_id) == $key ? 'selected' : '' }}>
                    {{ $category }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('referred_by', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="title">Meta Title</label>
        <span class="text-danger font-bolder">*</span>
        <input class="form-control" name="meta_title" type="text" id="metaTitle">

        {!! $errors->first('metaTitle', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="title">Meta Description</label>
        <span class="text-danger font-bolder">*</span>
        <textarea name="meta_description" id="metaDescription" cols="30" rows="10" class="form-control" minlength="1"
                  maxlength="1000"></textarea>

        {!! $errors->first('metaDescription', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="title">Short Summery</label>
        <span class="text-danger font-bolder">*</span>
        <textarea name="short_summery" id="shortSummery" cols="30" rows="10" class="form-control" minlength="1"
                  maxlength="1000"></textarea>

        {!! $errors->first('shortSummery', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="title">Content</label>
        <span class="text-danger font-bolder">*</span>
        <textarea name="content" id="content" cols="30" rows="10" class="form-control ckeditor" minlength="1"
                  maxlength="1000"></textarea>

        {!! $errors->first('content', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="title">Author Name</label>
        <span class="text-danger font-bolder">*</span>
        <input class="form-control" name="author_name" type="text" id="authorName">

        {!! $errors->first('authorName', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="title">Date</label>
        <span class="text-danger font-bolder">*</span>
        <input class="form-control  {{ $errors->has('date') ? 'is-invalid' : '' }}" name="date" type="date" id="date"
               value="{{ old('date', optional($post)->date) }}">


        {!! $errors->first('date', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="title">Banner</label>
        <span class="text-danger font-bolder">*</span>
        <input class="form-control" name="banner" type="file" id="banner">

        {!! $errors->first('title', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="title">Featured Image</label>
        <span class="text-danger font-bolder">*</span>
        <input class="form-control" name="image" type="file" id="image" accept="image/*">

        {!! $errors->first('title', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="" class="col-md-4">Publish</label>
        <div class="col-md-8">
            <label for=""><input type="radio" name="status" value="1"> Yes </label>
            <label for=""><input type="radio" name="status" value="0"> No </label>
        </div>
    </div>
</div>


