<form id="user_settings_form" action="{{ route('master.user_settings_store') }}" method="post">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">User Settings- {{ $selected_user->name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <br>
    @csrf
    <div class="mx-4">
        <div class="form-group">
            <label for="">Choose Plan</label>
            <select class="form-control" name="plan_name" id="plan_name">
                <option value="Trial" @if(($selected_user->settings->plan_name??'Trial') == 'Trial') selected @endif>On Trial
                </option>
                <option value="Free" @if(($selected_user->settings->plan_name??'Trial') == 'Free') selected @endif>Free Plan
                </option>
                <option value="Basic" @if(($selected_user->settings->plan_name??'Trial') == 'Basic') selected @endif>Basic Plan
                </option>
                <option value="Premium" @if(($selected_user->settings->plan_name??'Trial') == 'Premium') selected @endif>Premium
                    Plan
                </option>
            </select>

        </div>

        <input type="hidden" name="client_id" value="{{ $selected_user->client_id }}">
        <input type="submit" id="user_settings_form_btn" hidden>
    </div>
    <div class="mx-4">
        <p> Joined at {{ \Carbon\Carbon::parse($selected_user->created_at) }}
            [<b>{{ \Carbon\Carbon::parse($selected_user->created_at)->diffForHumans() }}]</b></p>
        <p> Active at {{ \Carbon\Carbon::parse($selected_user->last_active_at) }}
            [<b>{{ \Carbon\Carbon::parse($selected_user->last_active_at)->diffForHumans() }}]</b></p>
    </div>
</form>
