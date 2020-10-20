<div class="row">

    <div class="col-sm-2">
        @component("lili::components.image-upload", ['field' => 'image', 'content' => $model])
        @endcomponent
    </div>
    <div class="col-sm-10">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', (!empty($model->user->name) ?$model->user->name: null), ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::text('email', (!empty($model->user->email) ?$model->user->email: null), ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('password', 'Nova Senha') !!}
                    {!! Form::text('password', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('cpf', 'CPF') !!}
                    {!! Form::text('cpf', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    {!! Form::label('phone', 'Telefone') !!}
                    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                </div>
            </div>

        </div>
    </div>
</div>
