@extends('orchestra/foundation::layouts.page')

@section('content')
<div class="row">
  <div class="col-md-9">
    {{ $form }}
  </div>
</div>
@stop

@push('orchestra.footer')
<script>
  var app = new App({
    data: {
      sidebar: {
        active: 'control-roles'
      }
    }
  }).$mount('body')
</script>
@endpush
