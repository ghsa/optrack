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

            @if(!empty($model->id))
            <div class="col-sm-12">
                <div class='row'>
                    <div class="col-sm-3">
                        <p>Preço Atual</p>
                        <h2>R$ {{$model->current_price}}</h2>
                    </div>
                    <div class="col-sm-3">
                        <p>Tendência</p>
                        <button class='btn btn-sm btn-{{\App\Models\Stock::$trendsClass[$model->short_trend]}}'>{{\App\Models\Stock::$trends[$model->short_trend]}}</button> /
                        <button class='btn btn-sm btn-{{\App\Models\Stock::$trendsClass[$model->middle_trend]}}'>{{\App\Models\Stock::$trends[$model->middle_trend]}}</button>
                    </div>
                    <div class="col-sm-3">
                        <p>Preço Atual</p>
                        <h2>R$ {{$model->current_price}}</h2>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-sm-12">
                <div class="form-group">
                    {!! Form::label('obs', 'OBS') !!}
                    {!! Form::textarea('obs', null, ['class' => 'form-control summernote']) !!}
                </div>
            </div>
        </div>
    </div>


</div>
