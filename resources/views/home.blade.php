@extends('orchestra/foundation::layouts.page')

@section('content')
<div class="row">
  <div class="jumbotron">
    <div class="page-header">
      <h2>Control for Orchestra Platform</h2>
    </div>
  </div>
</div>
@stop

@push('orchestra.footer')
<script>
  var app = Platform.make('app').nav('control').$mount('body')
</script>
@endpush
