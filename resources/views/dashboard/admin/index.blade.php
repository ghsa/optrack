@extends('dashboard.template')

@section('content')
@component('lili::components.title', [
'link' => route($model->getBaseRouteName() . '.create'),
'linkText' => 'Novo',
'icon' => 'fas fa-plus'
])
{{$model->getPageTitle()}}
@endcomponent

@component('lili::components.card', ['title' => 'Filtros'])
{!! Form::open(['route' => $model->getBaseRouteName().'.index']) !!}
<div class="row">
    <div class="col-sm-6 form-group">
        {!! Form::label('filters.name', 'Nome') !!}
        {!! Form::text('filters[users.name.like]', $filters->getValue('users.name.like'), ['class' => 'form-control']) !!}
    </div>
    <div class="col-sm-6 form-group">
        {!! Form::label('filters.email', 'Email') !!}
        {!! Form::text('filters[users.email.=]', $filters->getValue('users.email.='), ['class' => 'form-control']) !!}
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
    </div>
</div>
{!! Form::close() !!}
@endcomponent

@component('lili::components.card', ['title' => 'Lista'])
<table class="table table-dashed table-bordered">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $result)
        <tr>
            <td>
                {{$result->user->name}}
            </td>
            <td>
                {{$result->user->email}}
            </td>
            <td>
                <a href="{{route($result->getBaseRouteName() . '.show', ['id' => $result->id])}}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endcomponent
@endsection
