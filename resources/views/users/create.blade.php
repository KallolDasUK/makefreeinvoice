@extends('acc::layouts.app')

@section('content')
    @include('partials.settings-tab',['page'=>'users'])

    <div class="card">

        <div class="card-header">


            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('users.user.index') }}"
                   class="btn btn-primary   {{ ability(\App\Utils\Ability::PRODUCT_READ) }}" title="Show All User">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All User
                </a>
            </div>

        </div>

        <div class="card-body">


            <form method="POST" action="{{ route('users.user.store') }}" accept-charset="UTF-8" id="create_user_form"
                  name="create_user_form" class="form-horizontal">
                {{ csrf_field() }}
                @include ('users.form', ['edit_user' => null])

                <div class="form-group">
                    <button class="btn btn-primary" type="submit" style="width: 20%">
                        <svg width="20px" height="20px" class="mr-2" viewBox="0 0 24 24" version="1.1"
                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="ic_fluent_save_copy_24_filled" fill="currentColor" fill-rule="nonzero">
                                    <path
                                        d="M20.4961766,5.62668182 C21.3720675,5.93447702 22,6.76890777 22,7.75 L22,17.75 C22,20.0972102 20.0972102,22 17.75,22 L7.75,22 C6.76890777,22 5.93447702,21.3720675 5.62668182,20.4961766 L7.72396188,20.4995565 L17.75,20.5 C19.2687831,20.5 20.5,19.2687831 20.5,17.75 L20.5,7.75 L20.4960194,7.69901943 L20.4961766,5.62668182 Z M17.246813,2 C18.4894537,2 19.496813,3.00735931 19.496813,4.25 L19.496813,17.246813 C19.496813,18.4894537 18.4894537,19.496813 17.246813,19.496813 L4.25,19.496813 C3.00735931,19.496813 2,18.4894537 2,17.246813 L2,4.25 C2,3.00735931 3.00735931,2 4.25,2 L17.246813,2 Z M10.75,6.75 C10.3703042,6.75 10.056509,7.03215388 10.0068466,7.39822944 L10,7.5 L10,10 L7.5,10 C7.08578644,10 6.75,10.3357864 6.75,10.75 C6.75,11.1296958 7.03215388,11.443491 7.39822944,11.4931534 L7.5,11.5 L10,11.5 L10,14 C10,14.4142136 10.3357864,14.75 10.75,14.75 C11.1296958,14.75 11.443491,14.4678461 11.4931534,14.1017706 L11.5,14 L11.5,11.5 L14,11.5 C14.4142136,11.5 14.75,11.1642136 14.75,10.75 C14.75,10.3703042 14.4678461,10.056509 14.1017706,10.0068466 L14,10 L11.5,10 L11.5,7.5 C11.5,7.08578644 11.1642136,6.75 10.75,6.75 Z"
                                        id="🎨-Color"></path>
                                </g>
                            </g>
                        </svg>
                        Save User
                    </button>

                </div>

            </form>

        </div>
    </div>

@endsection


