
<div class="form-group">
    <div class="col-md-10">
        <label for="name">Name</label>


            @if(' required="true"'===' required="true"') <span class="text-danger font-bolder">*</span> @endif
        <input class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" type="text" id="name" value="{{ old('name', optional($paymentMethod)->name) }}" minlength="1" maxlength="255" data=" required="true""  placeholder="Enter name here...">

            {!! $errors->first('name', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="is_default">Is Default</label>


            <div class="checkbox">
            <label for="is_default_1">
            	<input id="is_default_1" class="" name="is_default" type="checkbox" value="1" {{ old('is_default', optional($paymentMethod)->is_default) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

            {!! $errors->first('is_default', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="description">Description</label>


            @if(''===' required="true"') <span class="text-danger font-bolder">*</span> @endif
        <input class="form-control  {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" type="text" id="description" value="{{ old('description', optional($paymentMethod)->description) }}" maxlength="255" data="" >

            {!! $errors->first('description', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

