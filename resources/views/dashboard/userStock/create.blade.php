@extends('dashboard.template')

@section('content')

@component('lili::components.title')
    {{$model->getPageTitle()}}
@endcomponent

@include('dashboard.messages')

@component('lili::components.card', ['title' => "Campos"])
    {!! Form::open(['route' => $model->getBaseRouteName().'.store', 'enctype' => 'multipart/form-data']) !!}
    @include($model->getBaseRouteName() . '.form')
    <div class="col-sm-12">
        <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Save</button>
    </div>
    {!! Form::close() !!}
@endcomponent

@endsection
