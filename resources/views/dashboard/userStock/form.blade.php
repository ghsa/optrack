<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('stock_id', 'Ação') !!}
                    {!! Form::select('stock_id',
                    \App\Models\Stock::orderBy('name')->get()->pluck('name', 'id'),
                    null,
                    ['class' => 'form-control'])
                    !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('buy_price', 'Preço Médio') !!}
                    {!! Form::text('buy_price', null, ['class' => 'form-control price']) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('amount', 'Quantidade') !!}
                    {!! Form::text('amount', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    {!! Form::label('fundamentalist_price', 'Análise Fundamentalista') !!}
                    {!! Form::text('fundamentalist_price', null, ['class' => 'form-control price']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
