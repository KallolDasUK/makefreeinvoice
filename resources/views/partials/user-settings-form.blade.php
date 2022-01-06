<form id="user_settings_form" action="{{ route('master.user_settings_store') }}" method="post">
    @csrf
    <p class="float-right"><b>{{ $selected_user->name }}</b></p>
    <div class="form-group">
        <label for="">Plan Name</label>
        <input class="form-control" type="text" name="custom_plan_name"
               value="{{ $selected_user->settings->custom_plan_name??'Premium Plan on Trial' }}">
    </div>
    <div class="form-group">
        <label for="">On Trial</label> <br>
        <label class="switch">
            <input type="hidden" name="on_trial" value="1">
            <input type="checkbox" name="on_trial" @if($selected_user->settings->on_trial??true) checked @endif>
            <span class="slider round"></span>
        </label>
    </div>
    <input type="hidden" name="client_id" value="{{ $selected_user->client_id }}">
    <input type="submit" id="user_settings_form_btn" hidden>
</form>
