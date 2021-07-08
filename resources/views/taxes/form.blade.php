<div class="form-group">
    <div class="col">
        <label for="name">Name</label>


        <span class="text-danger font-bolder">*</span>
        <input class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" type="text" id="name"
               value="{{ old('name', optional($tax)->name) }}">

        {!! $errors->first('name', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col">
        <label for="value">Value (%)</label>

        <span class="text-danger font-bolder">*</span>
        <input class="form-control  {{ $errors->has('value') ? 'is-invalid' : '' }}" name="value" type="number"
               step="any" id="value"
               value="{{ old('value', optional($tax)->value) }}"

        {!! $errors->first('value', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>
<br>
<div class="form-group">
    <div class="col">
        <label for="tax_type">Tax Type</label>


        <select class="form-control" id="tax_type" name="tax_type">

            @foreach (['%','Flat'] as  $text)
                <option value="{{ $text }}" {{ old('tax_type', optional($tax)->tax_type) == $text ? 'selected' : '' }}>
                    {{ $text }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('tax_type', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

