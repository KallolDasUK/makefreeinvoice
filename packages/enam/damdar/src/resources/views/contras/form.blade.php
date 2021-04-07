<div class="row">
    <div class="col">
        <div class="form-group {{ $errors->has('branch_id') ? 'has-error' : '' }}">
            <label for="branch_id" class="font-weight-bold text-black">Branch</label>

            <div>
                <select class="form-control branch" id="branch_id" name="branch_id">
                    <option disabled selected>-- Select Branch --</option>
                    @foreach ($branches as $key => $branch)
                        <option
                            value="{{ $key }}" {{ old('branch_id', optional($transaction)->branch_id) == $key ? 'selected' : '' }}>
                            {{ $branch }}
                        </option>
                    @endforeach
                </select>

                {!! $errors->first('branch_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="col">
        <div class="form-group {{ $errors->has('voucher_no') ? 'has-error' : '' }}">
            <label for="voucher_no" class="font-weight-bold text-black">Voucher No <span
                    class="text-danger font-weight-bold">*</span></label>

            <div>
                <input class="form-control  @error('voucher_no') is-invalid @enderror" name="voucher_no" type="text" id="voucher_no"
                       value="{{ old('voucher_no', optional($transaction)->voucher_no)??$voucher_no }}" minlength="1"
                       required>

                {!! $errors->first('voucher_no', '<p class="text-danger">:message</p>') !!}
            </div>
        </div>
    </div>

    <div class="col">
        <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
            <label for="date" class="font-weight-bold text-black">Voucher Date <span
                    class="text-danger font-weight-bold">*</span></label>

            <div>
                <input class="form-control picker" name="date" type="date" id="date"
                       value="{{ old('date', optional($transaction)->date) }}" minlength="1" required>

                {!! $errors->first('date', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
    </div>
</div>


<div id="target"></div>
<div class="form-group {{ $errors->has('note') ? 'has-error' : '' }} mt-4">
    <label for="note" class="font-weight-bold text-black">Note</label>

    <div>
        <textarea class="form-control" name="note" cols="50" rows="2" id="note" minlength="1"
                  maxlength="1000">{{ old('note', optional($transaction)->note) }}</textarea>
        {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
    </div>
</div>

