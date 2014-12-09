@extends('orchestra/foundation::layouts.page')

@section('content')
@include('orchestra/control::widgets.menu')

<div class="row white">
    @if (empty($themes))
    <div class="jumbotron">
        <div class="page-header">
            <h2>We can't find any theme yet!</h2>
        </div>
        <p>Don't worry, you can stil use Orchestra without a theme :)</p>
    </div>
    @else
        @include('orchestra/control::themes._list')
    @endif
</div>
@stop
