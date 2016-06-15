@extends('orchestra/foundation::layouts.page')

@set_meta('header::add-button', true)

@section('content')
<div class="row">
	<div class="twelve columns">
    <div class="panel panel-default">
      <div class="panel-body">
        {{ $table }}
      </div>
    </div>
	</div>
</div>
@stop

@push('orchestra.footer')
<script>
  var app = new App({
    data: {
      sidebar: {
        active: 'control'
      }
    }
  }).$mount('body')
</script>
@endpush
