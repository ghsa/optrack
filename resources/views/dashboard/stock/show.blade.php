@extends('dashboard.template')

@section('content')
@component('lili::components.title', [
'link' => route($model->getBaseRouteName() . '.index'),
'linkText' => 'Voltar',
'icon' => 'fas fa-arrow-left'
])
{{$model->getPageTitle()}}
@endcomponent

@include('dashboard.messages')

@component('lili::components.card', ['title' => 'Novo'])
{!! Form::model($model, ['route' => [$model->getBaseRouteName().'.update', $model->id], 'enctype' => 'multipart/form-data']) !!}
{!! Form::hidden('id', null) !!}
{!! Form::hidden('_method', 'PUT') !!}
@include($model->getBaseRouteName() . '.form')
<div class="col-sm-12">
    <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Save</button>
    <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#delete-modal">
        <i class="fas fa-trash"></i> Delete
    </button>
</div>
{!! Form::close() !!}
@endcomponent

@component('lili::components.card', ['title' => 'Opções'])
@include('dashboard.stock.options')
@endcomponent

@component('lili::components.modal', ['title' => 'Deletar', 'id' => 'delete-modal'])
<div class="modal-body">
    Deseja realmente deletar essa categoria?
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
    <form method="post" action="{{route($model->getBaseRouteName() . '.destroy', ['id' => $model->id])}}">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="DELETE" />
        <button type="submit" class="btn btn-danger">Confirmar</button>
    </form>
</div>
@endcomponent

@endsection
