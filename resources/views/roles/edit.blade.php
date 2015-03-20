@extends('orchestra/foundation::layouts.page')

@section('content')
@include('orchestra/control::widgets.header')

<div class="row">
	<div class="twelve columns rounded box">
		<div class="row">
			<div class="nine columns">
				{!! $form !!}
			</div>
		</div>
	</div>
</div>
@stop
