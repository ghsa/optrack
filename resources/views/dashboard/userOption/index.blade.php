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

    <div class="col-sm-2 form-group">
        {!! Form::label('filters.options.like', 'Nome') !!}
        {!! Form::text('filters[options.name.like]', $filters->getValue('options.name.like'), ['class' => 'form-control']) !!}
    </div>
    <div class="col-sm-2 form-group">
        {!! Form::label('filters.open', 'Aberta') !!}
        {!! Form::select('filters[open.=]', [1 => "Aberta", 0 => "Fechada"], $filters->getValue('open.='), ['class' => 'form-control']) !!}
    </div>
    <div class="col-sm-2 form-group">
        {!! Form::label('filters.options.type', 'Tipo') !!}
        {!! Form::select('filters[options.type.=]', ['call' => "CALL", 'put' => "PUT"], $filters->getValue('options.types.='), ['class' => 'form-control']) !!}
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
<table class="table table-dashed table-bordered table-hover">
    <thead>
        <tr>
            <th></th>
            <th>Opção</th>
            <th>Strike</th>
            <th>Atual</th>
            <th>%</th>
            <th>QTD</th>
            <th>Preço</th>
            <th>Total</th>
            <th style='width:80px'>Atual/Compra</th>
            <th>Saldo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalStocks = 0;
        $balance = 0;
        $totalWarranty = 0;
        ?>
        @foreach($results as $result)
        <?php
        $total = ($result->amount * $result->sell_price);
        $totalStocks += $total;
        $balance += $result->getResult() * $result->amount;
        $totalWarranty += $result->option->strike * $result->amount;
        ?>
        <tr>
            <td style='width: 50px'><img src="{{$result->option->stock->getFilePath('image')}}" class='w-100' /></td>
            <td>
                {{$result->option->name}} <br>
                <badge class='badge badge-{{$result->open ? 'primary' : 'warning'}}'>{{\App\Models\UserOption::$openStatus[$result->open]}}</badge>
                <badge class='badge badge-default'>{{$result->option->type}}</badge>
            </td>
            <td>R$ {{$result->option->strike}}
                <br>
                <span style='font-size: 13px;color: #777'>
                    R$ {{price($result->option->strike * $result->amount)}}
                </span>
            </td>
            <td style='color: {{$result->option->isITM() ? 'red' : 'blue'}}'>
                R$ {{$result->option->stock->current_price}}

            </td>
            <td>{{price(($result->option->strike - $result->option->spot_price) / $result->option->strike * 100)}}%</td>
            <td>{{$result->amount}}</td>
            <td style='font-weight: bold'>R$ {{price($result->sell_price)}} ({{price($result->sell_price / $result->option->strike * 100)}}%)
                <br>

            </td>
            <td>R$ {{price($result->sell_price * $result->amount)}}</td>
            <td>
                @if($result->open)
                R$ {{price($result->option->price)}}
                <badge class='badge badge-default'> R$ {{price($result->sell_price * config('app.buy_percentage'))}}</badge>
                @else R$ {{price($result->buy_price)}} @endif
            </td>
            <td style="color: {{$result->getResult() < 0 ? 'red' : 'green' }}">
                R$ {{price($result->getResult() * $result->amount)}} ({{price($result->getResult() / $result->option->strike * 100)}}%)
                <br>
                @if($result->open)
                <badge class='badge badge-{{\App\Models\UserOption::$recomendationClass[$result->getRecomendation()]}}'>{{$result->getRecomendation()}}</badge>
                @else
                <badge class='badge badge-warning'>Fechada</badge>
                @endif

            </td>
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
            <td></td>
            <td colspan='5' style='font-weight: bold'>R$ {{price($totalWarranty)}}</td>
            <td colspan='1' style='font-weight: bold'>R$ {{price($totalStocks)}}</td>
            <td colspan='1' style='font-weight: bold'></td>
            <td colspan='3'><span style='font-weight: bold;color: {{$balance < 0 ? 'red' : 'green'}}'> R$ {{price($balance)}} ({{price($balance / $totalWarranty * 100)}}%)</span></td>
        </tr>
    </tfoot>
</table>
@endcomponent
@endsection
