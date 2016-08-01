@extends('templates.master')

@section('components')
    <div class="components">
        @foreach($GLOBAL->config->components as $component)
            @include('components.' . $component->componentName . '.template', [$component->componentName => ${$component->name}])
        @endforeach
    </div>
@endsection