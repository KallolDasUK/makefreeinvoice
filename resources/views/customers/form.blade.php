<div class="form-group">
    <div class="col-md-10">
        <div class="row">
            <div class="col">
                <label for="name">Name</label>
                <span class="text-danger font-bolder">*</span>
                <input class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" type="text"
                       id="name"
                       value="{{ old('name', optional($customer)->name) }}" minlength="1" maxlength="255">
                {!! $errors->first('name', '<p class="form-text text-danger">:message</p>') !!}
            </div>
            <div class="col">
                <label for="sr_id">Sales Representative</label>
                <select name="sr_id" id="sr_id" class="form-control searchable">
                    <option></option>
                    @foreach(\App\Models\SR::all() as $sr)
                        <option value="{{ $sr->id }}"
                                @if(optional($customer)->sr_id == $sr->id) selected @endif> {{ $sr->name }} {{ $sr->phone }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>


</div>


<div class="col-md-10">
    <div class="row">
        <div class="col">
            <div class="{{ $errors->has('opening') ? 'has-error' : '' }}">
                <label for="opening">Opening</label>
                <div>
                    <input class="form-control" name="opening" type="number" id="opening"
                           value="{{ old('opening', optional($customer)->opening) }}" min="1" max="2147483647">
                    {!! $errors->first('opening', '<p class="text-danger">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col">
            <div class="{{ $errors->has('opening_type') ? 'has-error' : '' }}">
                <label for="opening_type">Opening Type</label>
                <div>
                    <select class="form-control" id="opening_type" name="opening_type">

                        @foreach (['Dr' => 'Previous Due','Cr' => 'Advance'] as $key => $text)
                            <option
                                value="{{ $key }}" {{ old('opening_type', optional($customer)->opening_type) == $key ? 'selected' : '' }}>
                                {{ $text }}
                            </option>
                        @endforeach
                    </select>

                    {!! $errors->first('opening_type', '<p class="text-danger">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col">
            <label for="photo">Profile Photo</label>


            <div class="input-group uploaded-file-group">
                <label class="input-group-btn">
                <span class="btn btn-default">
                     <input type="file" name="photo" id="photo" class="form-control-file">
                </span>
                </label>
                <input type="text" class="form-control uploaded-file-name" hidden>
            </div>

            @if (isset($customer->photo) && !empty($customer->photo))
                <div class="input-group input-width-input">
                <span class="input-group-addon">
                    <input type="checkbox" name="custom_delete_photo" class="custom-delete-file" value="1" {{ old('custom_delete_photo', '0') == '1' ? 'checked' : '' }}> Delete
                </span>

                    <span class="input-group-addon custom-delete-file-name">
                   <img class="card" src="{{ asset('storage/'.$customer->photo) }}" width="200">

                </span>
                </div>
            @endif

            {!! $errors->first('photo', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
</div>
<div class="col-md-10">
    <label for="company_name">Company Name</label>
    <input class="form-control  {{ $errors->has('company_name') ? 'is-invalid' : '' }}" name="company_name"
           type="text" id="company_name" value="{{ old('company_name', optional($customer)->company_name) }}"
           minlength="1" data="" placeholder="Enter company name here...">

</div>
<div class="form-group">
    <div class="col-md-10">
        <label for="phone">Phone</label>


        @if(''===' required="true"') <span class="text-danger font-bolder">*</span> @endif
        <input class="form-control  {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone" type="text" id="phone"
               value="{{ old('phone', optional($customer)->phone) }}" minlength="1" data=""
               placeholder="Enter phone here...">

        {!! $errors->first('phone', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="email">Email</label>


        @if(''===' required="true"') <span class="text-danger font-bolder">*</span> @endif
        <input class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" type="email"
               id="email" value="{{ old('email', optional($customer)->email) }}" data=""
               placeholder="Enter email here...">

        {!! $errors->first('email', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="country">Country</label>


        <select id="country" class="form-control" name="country">
            <option value="" disabled selected></option>
            @foreach(countries() as $country)
                <option value="{{ $country }}"
                        @if(optional($customer)->country === $country) selected @endif> {{ $country }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="street_1">Street 1</label>
        <input class="form-control  {{ $errors->has('street_1') ? 'is-invalid' : '' }}" name="street_1" type="text"
               id="street_1" value="{{ old('street_1', optional($customer)->street_1) }}" maxlength="191" data="">
    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="street_2">Street 2</label>
        <input class="form-control  {{ $errors->has('street_2') ? 'is-invalid' : '' }}" name="street_2" type="text"
               id="street_2" value="{{ old('street_2', optional($customer)->street_2) }}" maxlength="191" data="">

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="city">City</label>
        <input class="form-control  {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city" type="text" id="city"
               value="{{ old('city', optional($customer)->city) }}" maxlength="191" data="">


    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="state">State</label>

        <input class="form-control  {{ $errors->has('state') ? 'is-invalid' : '' }}" name="state" type="text" id="state"
               value="{{ old('state', optional($customer)->state) }}" maxlength="191" data="">

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="zip_post">Zip/Post Code</label>
        <input class="form-control  {{ $errors->has('zip_post') ? 'is-invalid' : '' }}" name="zip_post" type="text"
               id="zip_post" value="{{ old('zip_post', optional($customer)->zip_post) }}" maxlength="191" data="">
    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="website">Website</label>
        <input class="form-control  {{ $errors->has('website') ? 'is-invalid' : '' }}" name="website" type="text"
               id="website" value="{{ old('website', optional($customer)->website) }}" minlength="1" data=""
               placeholder="Enter website here...">


    </div>
</div>

