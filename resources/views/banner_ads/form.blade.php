<div class="form-group">
    <div class="col-md-10">
        <label for="title">Title</label>


        @if(''===' required="true"') <span class="text-danger font-bolder">*</span> @endif
        <input class="form-control  {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" type="text" id="title"
               value="{{ old('title', optional($bannerAd)->title) }}" minlength="1" maxlength="255" data=""
               placeholder="Enter title here...">

        {!! $errors->first('title', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="photo">Banner Image</label>


        <div class="input-group uploaded-file-group">
            <label class="input-group-btn">
                <span class="btn btn-default">
                     <input type="file" name="photo" id="photo" class="form-control-file">
                </span>
            </label>
            <input type="text" class="form-control uploaded-file-name" hidden>
        </div>

        @if (isset($bannerAd->photo) && !empty($bannerAd->photo))
            <div class="input-group input-width-input">
                <span class="input-group-addon">
                    <input type="checkbox" name="custom_delete_photo" class="custom-delete-file" value="1" {{ old('custom_delete_photo', '0') == '1' ? 'checked' : '' }}> Delete
                </span>

                <span class="input-group-addon custom-delete-file-name">
                   <img class="card" src="{{ asset('storage/'.$bannerAd->photo) }}" width="200">

                </span>
            </div>
        @endif

        {!! $errors->first('photo', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="link">Link</label>
        <span class="text-danger font-bolder">*</span>
        <input class="form-control  {{ $errors->has('link') ? 'is-invalid' : '' }}" name="link" type="url" id="link"
               value="{{ old('link', optional($bannerAd)->link) }}" minlength="1">

        {!! $errors->first('link', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="banner_type">Banner Type</label>


        <select class="form-control" id="banner_type" name="banner_type">
            <option value="" style="display: none;"
                    {{ old('banner_type', optional($bannerAd)->banner_type ?: '') == '' ? 'selected' : '' }} disabled
                    selected> -- Banner Type --
            </option>
            @foreach (['Vertical','Horizontal','Squire Box'] as $text)
                <option
                    value="{{ $text }}" {{ old('banner_type', optional($bannerAd)->banner_type) == $text ? 'selected' : '' }}>
                    {{ $text }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('banner_type', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

