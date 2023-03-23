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
        <label for="slug">Slug</label>
        <span class="text-danger font-bolder">*</span>
        <input class="form-control" name="slug" type="text" id="slug"
               value="{{ old('slug', optional($post)->slug) }}" >

        {!! $errors->first('slug', '<p class="form-text text-danger">:message</p>') !!}

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

        {!! $errors->first('category_id', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="title">Meta Title</label>
        <span class="text-danger font-bolder">*</span>
        <input class="form-control" name="meta_title" type="text" id="metaTitle"
               value="{{ old('meta_title', optional($post)->meta_title) }}" >

        {!! $errors->first('metaTitle', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="title">Meta Description</label>
        <span class="text-danger font-bolder">*</span>

        <textarea name="meta_description" id="metaDescription" cols="30" rows="10" class="form-control"
                  minlength="1" maxlength="1000" >{{ old('meta_description', optional($post)->meta_description) }}</textarea>


        {!! $errors->first('metaDescription', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="title">Short Summery</label>
        <span class="text-danger font-bolder">*</span>

        <textarea name="short_summery" id="shortSummery" cols="30" rows="10" class="form-control"
                  minlength="1" maxlength="1000" >{{ old('short_summery', optional($post)->short_summery) }}</textarea>


        {!! $errors->first('shortSummery', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="title">Content</label>
        <span class="text-danger font-bolder">*</span>

        <textarea name="content" id="content" cols="30" rows="10" class="form-control content"
                  minlength="1" maxlength="1000" >{{ old('content', optional($post)->content) }}</textarea>


        {!! $errors->first('content', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="title">Author Name</label>
        <span class="text-danger font-bolder">*</span>
        <input class="form-control" name="author_name" type="text" id="authorName"
               value="{{ old('author_name', optional($post)->author_name) }}">

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
        <input class="form-control" name="banner" type="file" id="banner"
               value="{{ old('banner', optional($post)->banner) }}">

        {!! $errors->first('banner', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="title">Featured Image</label>
        <span class="text-danger font-bolder">*</span>
        <input class="form-control" name="featured_image" type="file" id="image"
               value="{{ old('featured_image', optional($post)->featured_image) }}">

        {!! $errors->first('bannerS', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="" class="col-md-4">Publish</label>
        <div class="col-md-8">
            <label for=""><input type="radio" name="published" value="1" {{ old('published', optional($post)->published) == 1? 'checked':'' }}> Yes</label>
            <label for=""><input type="radio" name="published" value="0" {{ old('published', optional($post)->published) == 0? 'checked':'' }}> No</label>

        </div>
    </div>
</div>

@push('scripts')
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };
    </script>
    <script>
        CKEDITOR.replace('content',options);
    </script>
@endpush
