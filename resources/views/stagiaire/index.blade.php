@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Stagiaire</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('stagiaire.create') }}"> Create New Stagiaire</a>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif


<table class="table table-bordered">
 <tr>
   <th>No</th>
   <th>Name</th>
   <th>Email</th>
   <th>Roles</th>
   <th width="280px">Action</th>
 </tr>
 @foreach ($data as $key => $stagiaire)
  <tr>
    <td>{{ ++$i }}</td>
    <td>{{ $stagiaire->name }}</td>
    <td>{{ $stagiaire->email }}</td>
    <td>
      @if(!empty($stagiaire->getRoleNames()))
        @foreach($stagiaire->getRoleNames() as $v)
           <label class="badge badge-success">{{ $v }}</label>
        @endforeach
      @endif
    </td>
    <td>
       <a class="btn btn-info" href="{{ route('stagiaire.show',$stagiaire->id) }}">Show</a>
       <a class="btn btn-primary" href="{{ route('stagiaire.edit',$stagiaire->id) }}">Edit</a>
        {!! Form::open(['method' => 'DELETE','route' => ['stagiaire.destroy', $stagiaire->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </td>
  </tr>
 @endforeach
</table>


{!! $data->render() !!}


<p class="text-center text-primary"><small>Page des Stagiaire</small></p>
@endsection