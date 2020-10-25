<div class='col-sm-12'>
    <div class="row mb-4">
        <div class="col-sm-1">
            <img src="{{$option->stock->getFilePath('image')}}" alt="Logo" class='w-100'>
        </div>
        <div class="col-sm-3">
            <h2>
                {{$option->name}}
            </h2>
            <h4>
                {{$option->stock->name}}
            </h4>
            <h5>
                @if(!empty($userStock))
                PM R$ {{$userStock->buy_price}}
                @endif
            </h5>
        </div>
        <div class="col-sm-2">
            <h3>Strike</h3>
            <h5>R$ {{$option->strike}}</h5>
        </div>
        <div class="col-sm-2">
            <h3>Preço Atual</h3>
            <h5>R$ {{$option->stock->current_price}}
                ({{number_format(($option->strike - $option->stock->current_price) / $option->stock->current_price * 100, 2)}}%)
            </h5>
        </div>
        <div class="col-sm-2">
            <h3>Spot</h3>
            <h5>
                R$ {{$option->price}}
                ({{number_format(($option->price) / $option->stock->current_price * 100, 2)}}%)
            </h5>
        </div>

    </div>
    <hr>
    <div class="row">
        <input type='hidden' name='option_id' value='{{$option->id}}' />
        <div class="col-sm-2">
            <div class="form-group">
                {!! Form::label('open', 'Status') !!}
                {!! Form::select('open', [1 => 'Aberta', 0 => 'Fechada'], null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                {!! Form::label('sell_date', 'Data de Venda') !!}
                {!! Form::date('sell_date', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                {!! Form::label('buy_date', 'Data de Compra') !!}
                {!! Form::date('buy_date', null, ['class' => 'form-control']) !!}
            </div>
        </div>

    </div>
    <div class='row'>
        <div class="col-sm-2">
            <div class="form-group">
                {!! Form::label('amount', 'Quantidade') !!}
                {!! Form::text('amount', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="col-sm-3">
            <div class="form-group">
                {!! Form::label('sell_price', 'Preço de Venda') !!}
                {!! Form::text('sell_price', null, ['class' => 'form-control price']) !!}
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                {!! Form::label('buy_price', 'Preço de Compra') !!}
                {!! Form::text('buy_price', null, ['class' => 'form-control price']) !!}
            </div>
        </div>
    </div>
</div>
@if(!empty($model))
<hr>
<div class='col-sm-12'>
    <op-simulator :premium="{{$model->sell_price}}" :option="{{$model->option}}" :stock="{{$model->option->stock}}" />
</div>
@endif
