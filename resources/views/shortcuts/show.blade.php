@extends('acc::layouts.app')

@section('content')

<div class="card">
    <div class="card-header">

        <h5  class="my-1 float-left">{{ isset($shortcut->name) ? $shortcut->name : 'Shortcut' }}</h5>

        <div class="float-right">

            <form method="POST" action="{!! route('shortcuts.shortcut.destroy', $shortcut->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('shortcuts.shortcut.index') }}" class="btn btn-primary mr-2" title="Show All Shortcut">
                        <i class=" fas fa-fw fa-th-list" aria-hidden="true"></i>
                        Show All Shortcut
                    </a>

                    <a href="{{ route('shortcuts.shortcut.create') }}" class="btn btn-success mr-2" title="Create New Shortcut">
                        <i class=" fas fa-fw fa-plus" aria-hidden="true"></i>
                        Create New Shortcut
                    </a>

                    <a href="{{ route('shortcuts.shortcut.edit', $shortcut->id ) }}" class="btn btn-primary mr-2" title="Edit Shortcut">
                        <i class=" fas fa-fw fa-pencil-alt" aria-hidden="true"></i>
                        Edit Shortcut
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Shortcut" onclick="return confirm(&quot;Click Ok to delete Shortcut.?&quot;)">
                        <i class=" fas fa-fw fa-trash-alt" aria-hidden="true"></i>
                        Delete Shortcut
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="card-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $shortcut->name }}</dd>
            <dt>Link</dt>
            <dd>{{ $shortcut->link }}</dd>

        </dl>

    </div>
</div>

@endsection
