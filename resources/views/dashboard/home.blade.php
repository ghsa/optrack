@extends('dashboard.template')

@section('content')

@component('lili::components.modal', [
'id' => 'id',
'title' => "Confirmar deleção"
])
Modal Content
@endcomponent

@component("lili::components.title", [
])
Control Panel
@endcomponent


@component('lili::components.card', ['title' => ''])

@endcomponent

@endsection
