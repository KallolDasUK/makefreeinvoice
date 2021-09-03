<div class="form-group">
    <div class="col-md-10">
        <label for="title">Title</label>

        <span class="text-danger font-bolder">*</span>
        <input class="form-control  {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" type="text" id="title"
               value="{{ old('title', optional($blog)->title) }}" minlength="1" maxlength="255" data=""
               placeholder="Enter title here...">

        {!! $errors->first('title', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="title">SLUG</label>

        <span class="text-danger font-bolder">*</span>
        <input class="form-control  {{ $errors->has('title') ? 'is-invalid' : '' }}" name="slug" type="text" id="slug"
               value="{{ old('slug', optional($blog)->slug) }}"
               placeholder="Enter Slug Here">
        {!! $errors->first('slug', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>
<div class="form-group">
    <div class="col-md-10">
        <label for="title">Tags</label>

        <select name="tags[]" id="tags" multiple class="form-control">
            @foreach($blogTags as $blogTag)
                <option
                    value="{{ $blogTag->id }}" {{ in_array($blogTag->id,$tags)?'selected':'' }}> {{ $blogTag->name }}</option>
            @endforeach
        </select>


    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="body">Body</label>

        <span class="text-danger font-bolder">*</span>
        <textarea class="form-control " name="body" type="text" id="body"> {{  optional($blog)->body }}</textarea>

        {!! $errors->first('body', '<p class="form-text text-danger">:message</p>') !!}
        <p> {!!  optional($blog)->body !!}</p>
    </div>
</div>


