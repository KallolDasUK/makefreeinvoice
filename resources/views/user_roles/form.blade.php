<div class="row">
    <div class="col">
        <div class="form-group">

            <label for="name">Name</label>

            <span class="text-danger font-bolder">*</span>
            <input class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" type="text" required
                   id="name"
                   value="{{ old('name', optional($userRole)->name) }}" minlength="1" maxlength="255">
            {!! $errors->first('name', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label for="description">Description</label>
            <input class="form-control  {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description"
                   type="text"
                   id="description" value="{{ old('description', optional($userRole)->description) }}" minlength="1">
            {!! $errors->first('description', '<p class="form-text text-danger">:message</p>') !!}

        </div>
    </div>
</div>

<table class="table table-bordered  " id="RoleTbl">

    <thead>
    <tr>
        <th>SL No.</th>
        <th>Menu Title</th>
        <th>
            <div class="row">
                <div class="col">
                    <label style="cursor:pointer;" for="create">
                        Can <span class="text-danger">Create</span>
                    </label>
                </div>
                <div class="col">
                    <input type="checkbox" class="form-check-input h-20px w-20px" name="create" value="1"
                           id="create"
                           autocomplete="off">
                </div>
            </div>


        </th>
        <th>
            <div class="row">
                <div class="col">
                    <label style="cursor:pointer;" for="read">
                        Can <span class="text-danger">Read</span>
                    </label>
                </div>
                <div class="col">
                    <input type="checkbox" class="form-check-input h-20px w-20px" name="read" value="1"
                           id="read"
                           autocomplete="off">
                </div>
            </div>
        </th>
        <th>
            <div class="row">
                <div class="col">
                    <label style="cursor:pointer;" for="edit">
                        Can <span class="text-danger">Edit</span>
                    </label>
                </div>
                <div class="col">
                    <input type="checkbox" class="form-check-input h-20px w-20px" name="edit" value="1"
                           id="edit"
                           autocomplete="off">
                </div>
            </div>
        </th>
        <th>
            <div class="row">
                <div class="col">
                    <label style="cursor:pointer;" for="delete">
                        Can <span class="text-danger">Delete</span>
                    </label>
                </div>
                <div class="col">
                    <input type="checkbox" class="form-check-input h-20px w-20px" name="delete" value="1"
                           id="delete"
                           autocomplete="off">
                </div>
            </div>
        </th>
    </tr>
    </thead>

    <tbody>
    @foreach($features as $feature)
        <tr>
            <td><h2>{{ $loop->iteration }}</h2></td>
            <td class=""><b><h3>{{ $feature->name }}</h3></b></td>
            <td class="text-center">

                <label for="create{{$loop->iteration}}" style="width: 100%">
                    &nbsp;
                    <input type="hidden" name="create[{{$feature->code}}]"
                           value="0">
                    <input type="checkbox" class="form-check-input h-20px w-20px create"
                           name="create[{{$feature->code}}]" value="1"
                           id="create{{$loop->iteration}}"
                        {{ $feature->create?'checked':'' }}>

                </label>
            </td>

            <td class="text-center">
                <label for="read{{$loop->iteration}}" style="width: 100%">
                    &nbsp;
                    <input type="hidden" name="read[{{$feature->code}}]" value="0">

                    <input type="checkbox" class="form-check-input h-20px w-20px read" name="read[{{$feature->code}}]"
                           value="1"
                           id="read{{$loop->iteration}}"
                        {{ $feature->read?'checked':'' }}>
                </label>
            </td>
            <td class="text-center">
                <label for="edit{{$loop->iteration}}" style="width: 100%">
                    &nbsp;
                    <input type="hidden" name="edit[{{$feature->code}}]" value="0">

                    <input type="checkbox" class="form-check-input h-20px w-20px edit" name="edit[{{$feature->code}}]"
                           value="1"
                           id="edit{{$loop->iteration}}"

                        {{ $feature->edit?'checked':'' }}>
                </label>
            </td>
            <td class="text-center">
                <label for="delete{{$loop->iteration}}" style="width: 100%">
                    &nbsp;
                    <input type="hidden" name="delete[{{$feature->code}}]" value="0">

                    <input type="checkbox" class="form-check-input h-20px w-20px delete"
                           name="delete[{{$feature->code}}]" value="1"
                           id="delete{{$loop->iteration}}"

                        {{ $feature->delete?'checked':'' }}>
                </label>
            </td>


        </tr>
    @endforeach
    </tbody>
</table>




