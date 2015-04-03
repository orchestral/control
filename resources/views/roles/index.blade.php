@extends('orchestra/foundation::layouts.page')

@set_meta('header::add-button', true)

@section('content')

@include('orchestra/control::widgets.header')

<div class="row">
	<div class="twelve columns white rounded box">
		{!! $table !!}
	</div>
</div>
@stop
