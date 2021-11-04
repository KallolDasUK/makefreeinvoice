<div class="row">
    <div class="col">


        <div class="form-group">

            <label for="name">Name</label>
            <span class="text-danger font-bolder">*</span>
            <input class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" type="text"
                   id="name"
                   value="{{ old('name', optional($user)->name) }}" minlength="1" maxlength="255">

            {!! $errors->first('name', '<p class="form-text text-danger">:message</p>') !!}


        </div>

        <div class="form-group">

            <label for="email">Email</label>
            <span class="text-danger font-bolder">*</span>
            <input class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" type="email"
                   id="email" value="{{ old('email', optional($user)->email) }}">

            {!! $errors->first('email', '<p class="form-text text-danger">:message</p>') !!}

        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <span class="text-danger font-bolder">*</span>
            <input class="form-control  {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password"
                   type="password"
                   id="password">

            {!! $errors->first('password', '<p class="form-text text-danger">:message</p>') !!}
        </div>
        <div class="form-group">
            <label for="password">Confirmed Password</label>
            <span class="text-danger font-bolder">*</span>
            <input class="form-control  {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password_confirmation"
                   type="password"
                   id="password_confirmation">

            {!! $errors->first('password_confirmation', '<p class="form-text text-danger">:message</p>') !!}
        </div>

    </div>
    <div class="col align-self-center">
        <h2>Role <a href="{{ route('user_roles.user_role.create') }}" target="_blank">Create Role</a></h2>
        <hr>
        <select name="role_id" id="role_id" class="searchable form-control" >
            <option value="" disabled selected></option>
            @foreach ($roles as $role)
                <option
                    value="{{ $role->id }}" {{ old('role_id', optional($user)->role_id) == $role->id ? 'selected' : '' }}>
                    {{ $role->name }} [{{ $role->description }}]
                </option>
            @endforeach
        </select>

    </div>
</div>

