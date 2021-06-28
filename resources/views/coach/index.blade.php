@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Coach</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('coach.create') }}"> Create New coach</a>
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
 @foreach ($data as $key => $coach)
  <tr>
    <td>{{ ++$i }}</td>
    <td>{{ $coach->name }}</td>
    <td>{{ $coach->email }}</td>
    <td>
      @if(!empty($coach->getRoleNames()))
        @foreach($coach->getRoleNames() as $v)
           <label class="badge badge-success">{{ $v }}</label>
        @endforeach
      @endif
    </td>
    <td>
       <a class="btn btn-info" href="{{ route('coach.show',$coach->id) }}">Show</a>
       <a class="btn btn-primary" href="{{ route('coach.edit',$coach->id) }}">Edit</a>
        {!! Form::open(['method' => 'DELETE','route' => ['coach.destroy', $coach->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </td>
  </tr>
 @endforeach

</table>


{!! $data->render() !!}


<p class="text-center text-primary"><small>Pages des Coachs</small></p>
@endsection