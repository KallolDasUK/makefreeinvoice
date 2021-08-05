@extends('acc::layouts.app')


@section('content')


    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="mdi mdi-information-outline"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif
    @include('partials.settings-tab',['page'=>'general_settings'])
    <form method="post" action="{{ route('accounting.settings.update') }}" style="margin-bottom: 50px"
          enctype="multipart/form-data">
        @csrf
        <div class="mx-auto text-right">
            <button type="submit" class="btn btn-primary btn-lg">Save Settings</button>

        </div>
        <div class="form-group row">
            <div class="col-form-label font-weight-bolder col-lg-2">Your Logo</div>
            <div class="col-lg-10 ">
                <div class="row">
                    <div class="text-center col-lg-3">
                        <div class="" style="width: 150px;height: 150px">
                            <div class="image-input image-input-outline" id="kt_image_1">
                                <div class="image-input-wrapper"
                                     @if($settings->business_logo??false)
                                     style="background-image: url({{ asset('storage/'.$settings->business_logo)}})"></div>
                                @else
                                    style="background-image: url(
                                    https://res.cloudinary.com/teepublic/image/private/s--lPknYmIq--/t_Resized%20Artwork/c_fit,g_north_west,h_954,w_954/co_000000,e_outline:48/co_000000,e_outline:inner_fill:48/co_ffffff,e_outline:48/co_ffffff,e_outline:inner_fill:48/co_bbbbbb,e_outline:3:1000/c_mpad,g_center,h_1260,w_1260/b_rgb:eeeeee/c_limit,f_auto,h_630,q_90,w_630/v1524123000/production/designs/2605867_0.jpg)">
                            </div>
                            @endif

                            <label
                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                data-action="change" data-toggle="tooltip" title=""
                                data-original-title="Change avatar">
                                <i class="fa fa-pen icon-sm text-muted"></i>
                                <input type="file" name="business_logo" accept=".png, .jpg, .jpeg"/>
                                <input type="hidden" name="profile_avatar_remove"/>
                            </label>

                            <span
                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
  <i class="ki ki-bold-close icon-xs text-muted"></i>
 </span>
                        </div>

                    </div>
                </div>
                <div class="col-lg-5 font-xs">
                    <div class="text-muted">This logo will appear on the documents (estimates, invoices,
                        etc.) that are created.
                    </div>
                    <small class="form-text">Preferred Image Size: 240px x 240px @ 72 DPI Maximum size of
                        1MB.</small> <a class="d-none" href="#" data-ember-action=""
                                        data-ember-action-452="452">Remove logo</a></div>
            </div>
        </div>
        </div>
        <div class="form-group row">
            <div class="col-form-label col-lg-2 required">
                <label class="font-weight-bolder text-danger"> Business Name *</label>
            </div>
            <div class="col-lg-4">
                <input type="text" class="form-control" name="business_name" value="{{ $settings->business_name??'' }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-form-label col-lg-2 required">
                <label class="font-weight-bolder"> Industry </label>
            </div>
            <div class="col-lg-4">
                <input class="form-control" name="industry" type="text" value="{{ $settings->industry??'' }}">

            </div>
        </div>
        <div class="form-group row">
            <div class="col-form-label col-lg-2 required">
                <label class="font-weight-bolder"> Business Location </label>
            </div>
            <div class="col-lg-4">
                <select id="business_location" class="form-control" name="business_location">
                    <option value="" disabled selected></option>
                    @foreach(countries() as $country)
                        <option value="{{ $country }}"
                                @if(($settings->business_location??'') === $country) selected @endif> {{ $country }}</option>
                    @endforeach
                </select>

            </div>
        </div>
        <div class="form-group row">
            <div class="col-form-label col-lg-2">
                <label class="font-weight-bolder"> Company Address </label>
            </div>
            <div class="col-lg-8 ">
                <input placeholder="Street 1" id="street_1" name="street_1" class=" form-control" type="text"
                       value="{{ $settings->street_1??'' }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-8 offset-lg-2">
                <input placeholder="Street 2" id="street_2" name="street_2" class="form-control" type="text"
                       value="{{ $settings->street_2??'' }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-8 offset-lg-2">
                <div class="row">
                    <div class="col-lg-4">
                        <input placeholder="City" id="city" name="city"
                               value="{{ $settings->city??'' }}"
                               class="form-control"
                               type="text">
                    </div>
                    <div class="col-lg-4">
                        <div>
                            <input placeholder="State/Province *"
                                   class="form-control"
                                   type="text"
                                   name="state"
                                   value="{{ $settings->state??'' }}">

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <input placeholder="Zip/Postal Code" id="zip_post" name="zip_post"
                               value="{{ $settings->zip_post??'' }}"
                               class="form-control" type="text">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-8 offset-lg-2">
                <div class="row">
                    <div class="col-lg-4">
                        <input placeholder="Phone" id="phone" name="phone"
                               class="form-control" type="phone" value="{{ $settings->phone??'' }}"></div>
                    <div class="col-lg-4">
                        <input placeholder="Email" id="email" name="email"
                               class="form-control" type="email" value="{{ $settings->email??'' }}"></div>
                    <div class="col-lg-4">
                        <input placeholder="Website" id="website" name="website"
                               class="form-control" type="url" value="{{ $settings->website??'' }}"></div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-form-label col-lg-2"><span class="font-weight-bolder"> Base Currency </span>
            </div>
            <div class="col-lg-4">
                <select class=" form-control select2" id="currency" name="currency">
                    <option value="" disabled selected></option>
                    @foreach (currencies() as $currency)
                        <option
                            value="{{ $currency['symbol'] }}" {{ ($settings->currency??'') == $currency['symbol'] ? 'selected' : '' }} >
                            {{ $currency['name'] ?? $currency['currencyname'] }} - {{ $currency['symbol'] }}
                        </option>
                    @endforeach
                </select>

            </div>
        </div>
        <div class="mx-auto text-right">
            <button type="submit" class="btn btn-primary btn-lg">Save Settings</button>

        </div>
    </form>



@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#business_location').select2({placeholder: " -- Country --"})
            $('#currency').select2({placeholder: " ----"})
            $('#ledger_group_id').select2();
            var avatar1 = new KTImageInput('kt_image_1');

        })
    </script>
@endsection
