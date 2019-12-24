@extends('layout.app')
@section('content')
  <div class="row">
  <div class="col-sm-12">
    <div class="full-right">
      <h2>CRUD Resource</h2>
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
      <th with="80px">No</th>
      <th>Name</th>
      <th>Address</th>
      <th>Mobileno</th>
      <th>Email</th>
      <th>DOB</th>
      <th with="140px" class="text-center">
        <a href="#" class="btn btn-success btn-sm">
          <i class="glyphicon glyphicon-plus"></i>
        </a>
      </th>
    </tr>
    <?php $no=1; ?>
    @foreach ($Employee as $key => $value)
      <tr>
        <td>{{$no++}}</td>
        <td>{{ $value->name }}</td>
        <td>{{ $value->address }}</td>
        <td>{{ $value->mobileno }}</td>
        <td>{{ $value->email }}</td>
        <td>{{ $value->dob }}</td>
        <td>
          <a class="btn btn-info btn-sm" href="">
              <i class="glyphicon glyphicon-th-large"></i></a>
          <a class="btn btn-primary btn-sm" href="">
              <i class="glyphicon glyphicon-pencil"></i></a>
            {!! Form::open(['method' => 'DELETE','route' => ['posts.destroy', $value->id],'style'=>'display:inline']) !!}
              <button type="submit" style="display: inline;" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i></button>
            {!! Form::close() !!}-->
        </td>
      </tr>
    @endforeach
  </table>
@endsection
