<div class="row">
    <div class="col-6">
        <div class="form-group  ">
            <label for="group_name" class="text-black font-weight-bold">Group Name</label>
            <div class="">
                <input class="form-control " name="group_name"
                       type="text" id="group_name"
                       value="{{ old('group_name', optional($ledgerGroup)->group_name) }}" minlength="1">
                {!! $errors->first('group_name', '<p class="text-danger">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group "
             style="{{ optional($ledgerGroup)->is_default?'pointer-events:none':'' }}">
            <label for="parent" class="text-black font-weight-bold">Under</label>
            <div>

                <select class="form-control {{ $errors->has('parent') ? 'is-invalid' : '' }}" id="parent"
                        name="parent">
                    <option></option>
                    @foreach (\Enam\Acc\Models\LedgerGroup::all() as $key => $text)

                        <option
                            value="{{ $text->id }}" {{ old('parent', optional($ledgerGroup)->parent) === $text->id ? 'selected' : '' }}>
                            {{ $text->group_name }}
                        </option>

                    @endforeach

                    <option
                        value="-1" {{ old('parent', optional($ledgerGroup)->parent) === -1 ? 'selected' : '' }}>
                        Primary
                    </option>
                </select>
                {!! $errors->first('parent', '<p class="text-danger">:message</p>') !!}
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-6">
        <div class="form-group {{ $errors->has('nature') ? 'has-error' : '' }}"
             style="{{ optional($ledgerGroup)->is_default?'pointer-events:none':'' }}">
            <label for="nature" class="text-black font-weight-bold">Nature</label>
            <div>
                <select class="form-control" id="nature"
                        name="nature" {{ optional($ledgerGroup)->parent !== -1? 'disabled style="cursor: no-drop"':''}}>
                    <option value=""
                            {{ old('nature', optional($ledgerGroup)->nature ?: '') == '' ? 'selected' : '' }} disabled
                            selected>
                        Enter nature here...
                    </option>
                    @foreach (['Asset' => 'Asset',
        'Liabilities' => 'Liabilities',
        'Income' => 'Income',
        'Expense' => 'Expense'] as $key => $text)
                        <option
                            value="{{ $key }}" {{ old('nature', optional($ledgerGroup)->nature) == $key ? 'selected' : '' }}>
                            {{ $text }}
                        </option>
                    @endforeach
                </select>

                {!! $errors->first('nature', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group {{ $errors->has('cashflow_type') ? 'has-error' : '' }}"
             style="{{ optional($ledgerGroup)->is_default?'pointer-events:none':'' }}">
            <label for="cashflow_type" class="text-black font-weight-bold">Cashflow Type</label>
            <div>
                <select class="form-control" id="cashflow_type"
                        name="cashflow_type" {{ optional($ledgerGroup)->parent !== -1? 'disabled style="cursor: no-drop"':''}}>
                    <option value="" style="display: none;"
                            {{ old('cashflow_type', optional($ledgerGroup)->cashflow_type ?: '') == '' ? 'selected' : '' }} disabled
                            selected>Enter cashflow type here...
                    </option>
                    @foreach (['Operating Activities' => 'Operating Activities', 'Investing Activities' => 'Investing Activities','Financial Activities' => 'Financial Activities'] as $key => $text)
                        <option
                            value="{{ $key }}" {{ old('cashflow_type', optional($ledgerGroup)->cashflow_type) == $key ? 'selected' : '' }}>
                            {{ $text }}
                        </option>
                    @endforeach
                </select>

                {!! $errors->first('cashflow_type', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

    </div>
</div>




