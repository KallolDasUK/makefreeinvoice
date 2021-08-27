<div class="form-group">
    <div class="col-md-10">
        <label for="name">Name</label>


        <span class="text-danger font-bolder">*</span>
        <input class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" type="text" id="name"
               value="{{ old('name', optional($vendor)->name) }}" minlength="1" maxlength="255" data=" required=" true""
        placeholder="Enter name here...">

        {!! $errors->first('name', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="photo">Photo</label>


        <div class="input-group uploaded-file-group">
            <label class="input-group-btn">
                <span class="btn btn-default">
                     <input type="file" name="photo" id="photo" class="form-control-file">
                </span>
            </label>
            <input type="text" class="form-control uploaded-file-name" hidden>
        </div>

        @if (isset($vendor->photo) && !empty($vendor->photo))
            <div class="input-group input-width-input">
                <span class="input-group-addon">
                    <input type="checkbox" name="custom_delete_photo" class="custom-delete-file" value="1" {{ old('custom_delete_photo', '0') == '1' ? 'checked' : '' }}> Delete
                </span>

                <span class="input-group-addon custom-delete-file-name">
                   <img class="card" src="{{ asset('storage/'.$vendor->photo) }}" width="200">

                </span>
            </div>
        @endif

        {!! $errors->first('photo', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="company_name">Company Name</label>


        <input class="form-control  {{ $errors->has('company_name') ? 'is-invalid' : '' }}" name="company_name"
               type="text" id="company_name" value="{{ old('company_name', optional($vendor)->company_name) }}"
               minlength="1" data="" placeholder="Enter company name here...">

        {!! $errors->first('company_name', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="phone">Phone</label>


        <input class="form-control  {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone" type="text" id="phone"
               value="{{ old('phone', optional($vendor)->phone) }}" minlength="1" data=""
               placeholder="Enter phone here...">

        {!! $errors->first('phone', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="email">Email</label>


        <input class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" type="email"
               id="email" value="{{ old('email', optional($vendor)->email) }}" data=""
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
                <option value="{{ $country }}"{{ old('country', optional($vendor)->country) == $country ? 'selected' : '' }}> {{ $country }}</option>
            @endforeach
        </select>


    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="street_1">Street 1</label>


        <input class="form-control  {{ $errors->has('street_1') ? 'is-invalid' : '' }}" name="street_1" type="text"
               id="street_1" value="{{ old('street_1', optional($vendor)->street_1) }}" minlength="1" data=""
               placeholder="Enter street 1 here...">

        {!! $errors->first('street_1', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="street_2">Street 2</label>


        <input class="form-control  {{ $errors->has('street_2') ? 'is-invalid' : '' }}" name="street_2" type="text"
               id="street_2" value="{{ old('street_2', optional($vendor)->street_2) }}" minlength="1" data=""
               placeholder="Enter street 2 here...">

        {!! $errors->first('street_2', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="city">City</label>


        <input class="form-control  {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city" type="text" id="city"
               value="{{ old('city', optional($vendor)->city) }}" minlength="1" data=""
               placeholder="Enter city here...">

        {!! $errors->first('city', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="state">State</label>


        <input class="form-control  {{ $errors->has('state') ? 'is-invalid' : '' }}" name="state" type="text" id="state"
               value="{{ old('state', optional($vendor)->state) }}" minlength="1" data=""
               placeholder="Enter state here...">

        {!! $errors->first('state', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="zip_post">Zip Post</label>


        <input class="form-control  {{ $errors->has('zip_post') ? 'is-invalid' : '' }}" name="zip_post" type="text"
               id="zip_post" value="{{ old('zip_post', optional($vendor)->zip_post) }}" minlength="1" data=""
               placeholder="Enter zip post here...">

        {!! $errors->first('zip_post', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="address">Address</label>


        <input class="form-control  {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" type="text"
               id="address" value="{{ old('address', optional($vendor)->address) }}" minlength="1" data=""
               placeholder="Enter address here...">

        {!! $errors->first('address', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="website">Website</label>


        <input class="form-control  {{ $errors->has('website') ? 'is-invalid' : '' }}" name="website" type="text"
               id="website" value="{{ old('website', optional($vendor)->website) }}" minlength="1" data=""
               placeholder="Enter website here...">

        {!! $errors->first('website', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

