@if($errors->any())
@foreach($errors->all() as $error)
<div class="card bg-danger text-white shadow mb-4">
    <div class="card-body card-message">
        <span class="fa fa-exclamation-triangle margin-right" aria-hidden="true"></span>
        {!! $error !!}
    </div>
</div>
@endforeach
@endif

@if(session('error'))
<div class="card bg-danger text-white shadow mb-4">
    <div class="card-body card-message">
        <span class=" fa fa-exclamation-triangle margin-right" aria-hidden="true"></span> {!!
        session('error') !!}
    </div>
</div>
@endif

@if(session('success'))
<div class="card bg-success text-white shadow mb-4">
    <div class="card-body">
        <span class=" fa fa-check-circle margin-right" aria-hidden="true"></span> {!!
        session('success') !!}
    </div>
</div>
@endif

@if(session('info'))
<div class="card bg-info text-white shadow mb-4">
    <div class="card-body card-message">
        <span class="fa fa-info-circle margin-right" aria-hidden="true"></span>
        {!! session('info')!!}
    </div>
</div>
@endif
