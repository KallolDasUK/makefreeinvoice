<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="font-weight-bold text-black">Name</label>

    <div>
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($branch)->name) }}"
               minlength="1" maxlength="255">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('location') ? 'has-error' : '' }}">
    <label for="location" class="font-weight-bold text-black">Location</label>

    <div>
        <input class="form-control" name="location" type="text" id="location"
               value="{{ old('location', optional($branch)->location) }}">
        {!! $errors->first('location', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description" class="font-weight-bold text-black">Description</label>

    <div>
        <textarea class="form-control" name="description" cols="50" rows="10" id="description"
                  maxlength="1000">{{ old('description', optional($branch)->description) }}</textarea>
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

