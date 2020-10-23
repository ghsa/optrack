<div class="row">
    <div class="col-sm-2">
        @component('lili::components.image-upload', ['field' => 'image', 'content'=> $model])
        @endcomponent
    </div>
    <div class="col-sm-10">
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
            <div class="col-sm-12">
                @if(!empty($model->id))
                <p>Preço Atual</p>
                <h2>R$ {{$model->current_price}}</h2>
                @endif
            </div>
        </div>
    </div>


</div>
