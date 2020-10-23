@extends('dashboard.template')

@section('content')

@component('lili::components.card', ['title' => 'Filtros'])
{!! Form::open(['route' => $model->getBaseRouteName().'.index']) !!}
<div class="row">
    <div class="col-sm-12 form-group">
        {!! Form::label('filters.stock_id', 'Ação') !!}
        {!! Form::select('filters[stock_id.=]', app(\App\Repositories\OptionRepository::class)->getOptionsArray(), $filters->getValue('stock_id.='), ['class' => 'form-control']) !!}
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
            <th>Opção</th>
            <th>Strike</th>
            <th>Spot</th>
            <th>%</th>
            <th>QTD</th>
            <th>Preço</th>
            <th>Total</th>
            <th>Atual</th>
            <th>%</th>
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
            <td style='width: 50px'><img src="{{$result->option->stock->getFilePath('image')}}" class='w-100' /></td>
            <td>
                {{$result->option->name}}
            </td>
            <td>R$ {{$result->option->strike}}</td>
            <td>R$ {{$result->option->spot_price}}</td>
            <td>R$ {{$result->option->strike / $result->option->spot_price}}%</td>
            <td>{{$result->amount}}</td>
            <td>R$ {{$result->sell_price}}</td>
            <td>R$ {{$result->option->sell_price * $result->amount}}</td>
            <td>R$ {{$result->option->sell_price * $result->amount}}</td>
            <td>R$ {{$result->option->price}}</td>
            <td>R$ {{$result->sell_price / $result->option->price}}%</td>
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
