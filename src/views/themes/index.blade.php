@include('orchestra/control::widgets.menu')

<div class="container">
    <div class="row">
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
</div>
