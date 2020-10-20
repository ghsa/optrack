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

@component('lili::components.card', ['title' => "Permissões"])
    {!! Form::model($model, ['route' => [$model->getBaseRouteName().'.permissions', $model->id], 'enctype' => 'multipart/form-data']) !!}
    {!! Form::hidden('_method', 'PUT') !!}
    <div class="row">
    @foreach(\Spatie\Permission\Models\Permission::all() as $permission)
        <div class="col-sm-3">
            <div class="form-check">
                <input type="checkbox" {{$model->user->can($permission->name) ? 'checked' : ''}} class="form-check-input" name="permissions[]" value="{{$permission->name}}" id="permission-{{$permission->id}}">
                <label class="form-check-label" for="permission-{{$permission->id}}">{{ucwords(str_replace("_", " ", $permission->name))}}</label>
            </div>
        </div>
    @endforeach
    </div>
    <div class="col-sm-12 mt-4">
        <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Save</button>
    </div>
    {!! Form::close() !!}

@endcomponent

@component('lili::components.modal', ['title' => 'Deletar', 'id' => 'delete-modal'])
    <div class="modal-body">
        Deseja realmente deletar esse administrador?
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
