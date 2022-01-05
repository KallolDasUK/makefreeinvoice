<form id="user_settings_form" action="{{ route('master.user_settings_store') }}">
    <h1>{{ $user->name }}</h1>
    <div class="form-group">
        <label for="">Plan Name</label>
        <input class="form-control" type="text" name="plan_name">
    </div>
    <div class="form-group">
        <label for="">On Trial</label>
        <input type="hidden" name="on_trial" value="0">
        <input class="form-control" type="checkbox" name="on_trial" @if($settings->on_trial??true) checked @endif>
    </div>
    <input type="submit" id="user_settings_form_btn" hidden>
</form>
