<div class="form-group">
    <div class="col-md-10">
        <label for="date">Date</label>
        <span class="text-danger font-bolder">*</span>
        <input class="form-control  {{ $errors->has('date') ? 'is-invalid' : '' }}" name="date" type="date" id="date"
               value="{{ old('date', optional($collectPayment)->date) }}">

        {!! $errors->first('date', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="for_month">For Month</label>

        <span class="text-danger font-bolder">*</span>
        <input class="form-control  {{ $errors->has('for_month') ? 'is-invalid' : '' }}" name="for_month" type="month"
               id="for_month" value="{{ old('for_month', optional($collectPayment)->for_month) }}" minlength="1">

        {!! $errors->first('for_month', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="user_id">User</label>

        <span class="text-danger font-bolder">*</span>

        <select class="form-control" id="user_id" name="user_id">
            <option value="" style="display: none;"
                    {{ old('user_id', optional($collectPayment)->user_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Select user
            </option>
            @foreach ($users as $key => $user)
                <option
                    value="{{ $key }}" {{ old('user_id', optional($collectPayment)->user_id) == $key ? 'selected' : '' }}>
                    {{ $user }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('user_id', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="amount">Amount</label>

        <span class="text-danger font-bolder">*</span>
        <input class="form-control  {{ $errors->has('amount') ? 'is-invalid' : '' }}" name="amount" type="number" step="any"
               id="amount" value="{{ old('amount', optional($collectPayment)->amount) }}" >

        {!! $errors->first('amount', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="referred_by">Referred By</label>


        <select class="form-control" id="referred_by" name="referred_by">
            <option value=""
                    {{ old('referred_by', optional($collectPayment)->referred_by ?: '') == '' ? 'selected' : '' }}
                    selected>Select referred by
            </option>
            @foreach ($users as $key => $user)
                <option
                    value="{{ $key }}" {{ old('referred_by', optional($collectPayment)->referred_by) == $key ? 'selected' : '' }}>
                    {{ $user }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('referred_by', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="referred_by_amount">Referred Commission Amount</label>


        <input class="form-control  {{ $errors->has('referred_by_amount') ? 'is-invalid' : '' }}"
               name="referred_by_amount" type="number" step="any" id="referred_by_amount"
               value="{{ old('referred_by_amount', optional($collectPayment)->referred_by_amount) }}">

        {!! $errors->first('referred_by_amount', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="note">Note</label>


        <textarea class="form-control" name="note" cols="50" rows="10" id="note" minlength="1"
                  maxlength="1000">{{ old('note', optional($collectPayment)->note) }}</textarea>
        {!! $errors->first('note', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

