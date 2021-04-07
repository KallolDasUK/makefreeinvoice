<div class="row">
    <div class="col">
        <div class="form-group {{ $errors->has('ledger_name') ? 'has-error' : '' }}">
            <label for="ledger_name" class="font-weight-bold text-black">Ledger Name <span
                    class="text-danger font-weight-bold">*</span></label>
            <div>
                <input class="form-control" name="ledger_name" type="text" id="ledger_name"
                       value="{{ old('ledger_name', optional($ledger)->ledger_name) }}" minlength="1">
                {!! $errors->first('ledger_name', '<p class="text-danger">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col">
        <div class="form-group {{ $errors->has('ledger_group_id') ? 'has-error' : '' }}">
            <label for="ledger_group_id" class="font-weight-bold text-black">Under <span
                    class="text-danger font-weight-bold">*</span></label></label>
            <div>
                <select class="form-control" id="ledger_group_id" name="ledger_group_id" >
                    <option value="" style="display: none;"
                            {{ old('ledger_group_id', optional($ledger)->ledger_group_id ?: '') == '' ? 'selected' : '' }} disabled
                            selected>Select ledger group
                    </option>
                    @foreach ($ledgerGroups as $key => $ledgerGroup)
                        <option
                            value="{{ $key }}" {{ old('ledger_group_id', optional($ledger)->ledger_group_id ?: '0') == $key ? 'selected' : '' }}>
                            {{ \Enam\Acc\Models\LedgerGroup::find($ledgerGroup)->group_name??'-' }}
                        </option>
                    @endforeach
                </select>

                {!! $errors->first('ledger_group_id', '<p class="text-danger">:message</p>') !!}
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col">
        <div class="form-group {{ $errors->has('opening') ? 'has-error' : '' }}">
            <label for="opening" class="font-weight-bold text-black">Opening</label>
            <div>
                <input class="form-control" name="opening" type="number" id="opening"
                       value="{{ old('opening', optional($ledger)->opening) }}" min="1" max="2147483647">
                {!! $errors->first('opening', '<p class="text-danger">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col">
        <div class="form-group {{ $errors->has('opening_type') ? 'has-error' : '' }}">
            <label for="opening_type" class="font-weight-bold text-black">Opening Type</label>
            <div>
                <select class="form-control" id="opening_type" name="opening_type">
                    <option value="" style="display: none;"
                            {{ old('opening_type', optional($ledger)->opening_type ?: '') == '' ? 'selected' : '' }} disabled
                            selected>--- Opening Type ---
                    </option>
                    @foreach (['Dr' => 'Dr','Cr' => 'Cr'] as $key => $text)
                        <option
                            value="{{ $key }}" {{ old('opening_type', optional($ledger)->opening_type) == $key ? 'selected' : '' }}>
                            {{ $text }}
                        </option>
                    @endforeach
                </select>

                {!! $errors->first('opening_type', '<p class="text-danger">:message</p>') !!}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="form-group {{ $errors->has('active') ? 'has-error' : '' }}">
            <label for="active" class="font-weight-bold text-black">Active</label>
            <div>
                <select class="form-control" id="active" name="active">

                    @foreach (['1' => 'Yes','0' => 'No'] as $key => $text)
                        <option
                            value="{{ $key }}" {{ old('active', optional($ledger)->active) === $key ? 'selected' : '' }}>
                            {{ $text }}
                        </option>
                    @endforeach
                </select>

                {!! $errors->first('active', '<p class="text-danger">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col"></div>
</div>


