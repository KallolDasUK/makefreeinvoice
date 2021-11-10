@extends('acc::layouts.app')

@section('content')
    @include('partials.settings-tab',['page'=>'shortcuts'])

    <div class="card">

        <div class="card-header">

            <h5  class="my-1 float-left">Create New Shortcut</h5>

            <div class="btn-group btn-group-sm float-right" role="group">
                <a href="{{ route('shortcuts.shortcut.index') }}" class="btn btn-primary" title="Show All Shortcut">
                    <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                    Show All Shortcut
                </a>
            </div>

        </div>

        <div class="card-body">



            <form method="POST" action="{{ route('shortcuts.shortcut.store') }}" accept-charset="UTF-8" id="create_shortcut_form" name="create_shortcut_form" class="form-horizontal">
            {{ csrf_field() }}
            @include ('shortcuts.form', [
                                        'shortcut' => null,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Add">
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection


