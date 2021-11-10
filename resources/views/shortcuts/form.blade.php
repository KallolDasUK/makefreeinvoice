
<div class="form-group">
    <div class="col-md-10">
        <label for="name">Name</label>


         <span class="text-danger font-bolder">*</span>
        <input class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" type="text" id="name" value="{{ old('name', optional($shortcut)->name) }}" minlength="1" maxlength="255" data=" required="true""  placeholder="Enter name here...">

            {!! $errors->first('name', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="link">Link</label>

 <span class="text-danger font-bolder">*</span>
        <input class="form-control  {{ $errors->has('link') ? 'is-invalid' : '' }}" name="link" type="url" id="link" value="{{ old('link', optional($shortcut)->link) }}" minlength="1" data=" required="true""  placeholder="Enter link here...">

            {!! $errors->first('link', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

