<div class="row">
    <div class="col-sm-3">
        @component('lili::components.image-upload', ['field' => 'image', 'content'=> $model])
        @endcomponent
    </div>
    <div class="col-sm-9">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('initials', 'Iniciais') !!}
                    {!! Form::text('initials', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('buy_price', 'Preço Médio') !!}
                    {!! Form::text('buy_price', null, ['class' => 'form-control price']) !!}
                </div>
            </div>
            <div class="col-sm-4">
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
