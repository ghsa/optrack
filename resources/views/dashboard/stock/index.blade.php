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
    <div class="col-sm-12 form-group">
        {!! Form::label('filters.name', 'Nome') !!}
        {!! Form::text('filters[name.like]', $filters->getValue('name.like'), ['class' => 'form-control']) !!}
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
            <th></th>
            <th>Name</th>
            <th>Preço</th>
            <th>Variação</th>
            <th>Curto/Médio</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $result)
        <tr>
            <td style='width: 80px'><img src="{{$result->getFilePath('image')}}" class='w-100' /></td>
            <td>
                {{$result->name}}
            </td>
            <td style='font-size: 15px;font-weight:bold'>R$ {{$result->current_price}}</td>
            <td style='font-weight: bold; color: {{$result->variation < 0 ? 'red' : 'green'}}'>{{$result->variation}}%</td>
            <td>
                <button class='btn btn-sm btn-{{\App\Models\Stock::$trendsClass[$result->short_trend]}}'>{{\App\Models\Stock::$trends[$result->short_trend]}}</button>
                <button class='btn btn-sm btn-{{\App\Models\Stock::$trendsClass[$result->middle_trend]}}'>{{\App\Models\Stock::$trends[$result->middle_trend]}}</button>
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
