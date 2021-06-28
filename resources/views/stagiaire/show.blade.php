@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2> Show Stagiaire</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('stagiaire.index') }}"> Back</a>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {{$stagiaire->name }}
            </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            {{$stagiaire->email }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Roles:</strong>
            @if(!empty($stagiaire->getRoleNames()))

            @foreach($stagiaire->getRoleNames() as $v)
                <label class="badge badge-success">{{ $v }}</label>
            @endforeach
        @endif
    </div>
</div>
</div>
@endsection