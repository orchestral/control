@extends('orchestra/foundation::layouts.page')

@php
use Orchestra\Support\Str;
@endphp

@section('header::right')
<div class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" id="acl-metric-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    {{ $collection[$metric] }}
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="acl-metric-menu">
    @foreach($collection as $id => $name)
    <li><a href="{{ URL::current() }}?name={{ $id }}">{{ $name }}</a></li>
    @endforeach
  </ul>
</div>
@stop

@section('content')
<form method="POST" action="{{ URL::current() }}" class="clearfix">
  {{ csrf_field() }}
  <input type="hidden" name="metric" value="{{ $metric }}">

  @foreach($roles as $roleId => $role)
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4>{{ $role['name'] }}</h4>
      </div>
      <div class="panel-body">
        <div class="row">
        @foreach($actions as $actionId => $action)
          {{ Form::checkbox("acl-{$roleId}-{$actionId}", 'yes', $eloquent->check($role['slug'], $action['slug']), [
            'id' => "acl-{$roleId}-{$actionId}",
          ]) }}
          <label for="acl-{{ $roleId }}-{{ $actionId }}" class="three columns checkboxes">
            {{ $action['name'] }}
            &nbsp;&nbsp;&nbsp;
          </label>
        @endforeach
        </div>
      </div>
    </div>
  @endforeach

  <div class="row">
    <div class="twelve columns">
      <button type="submit" class="btn btn-primary">{{ trans('orchestra/foundation::label.submit') }}</button>
      <a href="{{ handles("orchestra::control/acl/{$metric}/sync", ['csrf' => true]) }}" class="btn btn-link">
        {{ trans('orchestra/control::label.sync-roles') }}
      </a>
    </div>
  </div>
</form>
@stop

@push('orchestra.footer')
<script>
  var app = new App({
    data: {
      sidebar: {
        active: 'control-acl'
      }
    }
  }).$mount('body')
</script>
@endpush
