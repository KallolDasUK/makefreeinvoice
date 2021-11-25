<div class="form-group">
    <div class="col-md-10">
        <label for="date">Date</label>

        <span class="text-danger font-bolder">*</span>
        <input class="form-control  {{ $errors->has('date') ? 'is-invalid' : '' }}" name="date" type="date" id="date"
               value="{{ old('date', optional($paymentRequest)->date) }}" data="" placeholder="Enter date here...">

        {!! $errors->first('date', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="user_id">Affiliator</label>

        <span class="text-danger font-bolder">*</span>
        <select class="form-control searchable" id="user_id" name="user_id">
            <option value="" style="display: none;"
                    {{ old('user_id', optional($paymentRequest)->user_id ?: '') == '' ? 'selected' : '' }} disabled
                    selected> --
            </option>
            @foreach ($users as $key => $user)
                <option
                    value="{{ $key }}" {{ old('user_id', optional($paymentRequest)->user_id) == $key ? 'selected' : '' }}>
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
               id="amount" value="{{ old('amount', optional($paymentRequest)->amount) }}" >

        {!! $errors->first('amount', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="status">Status</label>

        <span class="text-danger font-bolder">*</span>
        <select class="form-control" id="status" name="status">
            <option value="" style="display: none;"
                    {{ old('status', optional($paymentRequest)->status ?: '') == '' ? 'selected' : '' }} disabled
                    selected>Enter status here...
            </option>
            @foreach (['Accepted','Processing', 'Approved', 'Rejected'] as $key => $text)
                <option
                    value="{{ $text }}" {{ old('status', optional($paymentRequest)->status) == $text ? 'selected' : '' }}>
                    {{ $text }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('status', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

<div class="form-group">
    <div class="col-md-10">
        <label for="note">Note</label>


        <textarea class="form-control" name="note" cols="50" rows="10" id="note" minlength="1"
                  maxlength="1000">{{ old('note', optional($paymentRequest)->note) }}</textarea>
        {!! $errors->first('note', '<p class="form-text text-danger">:message</p>') !!}

    </div>
</div>

