
<div class="form-group">
    <div class="col-md-10">
        <label for="type">Type</label>


            <select class="form-control" id="type" name="type" required="true">
        	    <option value="" style="display: none;" {{ old('type', optional($userNotification)->type ?: '') == '' ? 'selected' : '' }} disabled selected>Enter type here...</option>
        	@foreach (['Popup','Notice'] as $text)
			    <option value="{{ $text }}" {{ old('type', optional($userNotification)->type) == $text ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>

            {!! $errors->first('type', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="title">Title</label>

 <span class="text-danger font-bolder">*</span>
        <input class="form-control  {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" type="text" id="title" value="{{ old('title', optional($userNotification)->title) }}" minlength="1" maxlength="255" data=" required="true""  placeholder="Enter title here...">

            {!! $errors->first('title', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="body">Body</label>

        <span class="text-danger font-bolder">*</span>

            <textarea class="form-control" name="body" cols="50" rows="10" id="body" minlength="1" required="true" placeholder="Enter body here...">{{ old('body', optional($userNotification)->body) }}</textarea>
            {!! $errors->first('body', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="user_id">User</label>

        <span class="text-danger font-bolder">*</span>

            <select class="form-control" id="user_id" name="user_id">
        	    <option value="" style="display: none;" {{ old('user_id', optional($userNotification)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select user</option>
{{--        	@foreach ($users as $user)--}}
			    <option value="{{ $user->id }}" {{ old('user_id', optional($userNotification)->user_id) == $user->id ? 'selected' : '' }}>
			    	{{ $user->name }} {{ $user->email }} ({{ optional($user->settings)->phone }})
			    </option>
{{--			@endforeach--}}
        </select>

            {!! $errors->first('user_id', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group ">
    <div class="col-md-10 d-none">
        <label for="seen">Seen</label>
            @if(''===' required="true"') <span class="text-danger font-bolder">*</span> @endif
        <input class="form-control  {{ $errors->has('seen') ? 'is-invalid' : '' }}" name="seen" type="checkbox" id="seen" value="{{ old('seen', optional($userNotification)->seen) }}" >

            {!! $errors->first('seen', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

