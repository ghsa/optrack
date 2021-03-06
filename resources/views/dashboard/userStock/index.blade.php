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
            <th>PM</th>
            <th>QTD</th>
            <th>QTD</th>
            <th>Valor</th>
            <th>Fundamentalista</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php $totalStocks = 0; ?>
        @foreach($results as $result)
        <?php $total = ($result->amount * $result->stock->current_price);
        $totalStocks += $total;
        ?>
        <tr>
            <td style='width: 80px'><img src="{{$result->stock->getFilePath('image')}}" class='w-100' /></td>
            <td>
                {{$result->stock->name}}
            </td>
            <td>R$ {{$result->buy_price}}</td>
            <td>{{$result->amount}}</td>
            <td>R$ {{$result->stock->current_price}}</td>
            <td>R$ {{number_format($total, 2)}}</td>
            <td>R$ {{$result->fundamentalist_price}}</td>
            <td>
                <a href="{{route($result->getBaseRouteName() . '.show', ['id' => $result->id])}}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td colspan='4'></td>
            <td colspan='3'>R$ {{number_format($totalStocks, 2)}}</td>
        </tr>
    </tfoot>
</table>
@endcomponent
@endsection
