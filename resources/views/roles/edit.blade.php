@extends('orchestra/foundation::layouts.page')

@section('content')
<div class="row">
	<div class="twelve columns">
		<div class="row">
			<div class="nine columns">
				{{ $form }}
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
