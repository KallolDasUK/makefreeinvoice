
<div class="form-group">
    <div class="col-md-10">
        <label for="name">Name</label>


            @if(''===' required="true"') <span class="text-danger font-bolder">*</span> @endif
        <input class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" type="text" id="name" value="{{ old('name', optional($brand)->name) }}" maxlength="255" data=""  placeholder="Enter name here...">

            {!! $errors->first('name', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

