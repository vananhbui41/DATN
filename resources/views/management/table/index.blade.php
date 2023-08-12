@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row justify-content-center">
      @include('management.inc.sidebar')
      <div class="col-md-8">
        <i class="fas fa-chair"></i><span class="form-title">Bàn</span>
        <a href="/management/tables/create " class="btn btn-success btn-sm float-end"><i class="fas fa-plus"></i>Tạo bàn mới</a>
        <hr>
        @if(Session()->has('status'))
          <div class="alert alert-success">
            {{Session()->get('status')}}
          </div>
        @endif
        <table class="table table-bordered">
          <thead>
            <tr class="table-primary">
              <th scope="col">ID</th>
              <th scope="col">Bàn</th>
              <th scope="col">Trạng thái</th>
              <th scope="col">Sửa</th>
              <th scope="col">Xóa</th>
            </tr>
          </thead>
          <tbody>
            @foreach($tables as $table)
              <tr>
                <td>{{$table->id}}</td>
                <td>{{$table->name}}</td>
                <td>{{$table->status}}</td>
                <td>
                  <a href="/management/tables/{{$table->id}}/edit" class="btn btn-warning">Sửa</a>
                </td>
                <td>
                  <form action="/management/tables/{{$table->id}}" method="post">
                  @csrf 
                  @method('DELETE')
                  <input type="submit" value="Xóa" class="btn btn-danger">
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection