@extends('acc::layouts.app')

@section('content')
    @include('partials.settings-tab',['page'=>'users'])

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">{{ !empty($user->name) ? $user->name : 'User' }}</h5>

            <div class=" float-right" role="group">

                <a href="{{ route('users.user.index') }}" class="btn btn-primary mr-2 {{ ability(\App\Utils\Ability::USER_READ) }}" title="Show All User">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All User
                </a>

                <a href="{{ route('users.user.create') }}" class="btn btn-success {{ ability(\App\Utils\Ability::USER_CREATE) }}" title="Create New User">
                    <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                    Create New User
                </a>

            </div>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('users.user.update', $user->id) }}" id="edit_user_form" name="edit_user_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('users.form', [
                                        'user' => $user,
                                      ])

                <div class="form-group">
                    <button class="btn btn-primary" type="submit" style="width: 20%">
                        <svg class="mr-2" fill="currentColor" width="16px" height="16px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="none" stroke="currentColor" stroke-width="2" d="M1.7507,16.0022 C3.3517,20.0982 7.3367,23.0002 11.9997,23.0002 C18.0747,23.0002 22.9997,18.0752 22.9997,12.0002 M22.2497,7.9982 C20.6487,3.9012 16.6627,1.0002 11.9997,1.0002 C5.9247,1.0002 0.9997,5.9252 0.9997,12.0002 M8.9997,16.0002 L0.9997,16.0002 L0.9997,24.0002 M22.9997,0.0002 L22.9997,8.0002 L14.9997,8.0002"/>
                        </svg>

                        Update User
                    </button>
                </div>
            </form>

        </div>
    </div>

@endsection
