@extends('orchestra/foundation::layout.page')

<?php set_meta('header::add-button', true); ?>

@section('content')

@include('orchestra/control::widgets.menu')

<div class="row">
	<div class="twelve columns white rounded box">
		{!! $table !!}
	</div>
</div>
@stop