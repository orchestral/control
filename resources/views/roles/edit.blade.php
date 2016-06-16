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
  var app = Platform.make('app').nav('control-roles').$mount('body')
</script>
@endpush
