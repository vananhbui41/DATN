@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      @include('management.inc.sidebar')
      <div class="col-md-8">
        <h3><i class="fas fa-users"></i> Nhân Viên</h3>
        <a href="/management/user/create" class="btn btn-success btn-sm float-right"><i class="fas fa-plus"></i> Thêm Nhân Viên</a>
        <hr>
        @if(Session()->has('status'))
          <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">X</button>
            {{Session()->get('status')}}
          </div>
        @endif
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Họ Và Tên</th>
              <th scope="col">Chức vụ</th>
              <th scope="col">Email</th>
              <th scope="col">Sửa</th>
              <th scope="col">Xóa</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
              <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->role}}</td>
                <td>{{$user->email}}</td>
                <td><a href="/management/user/{{$user->id}}/edit" class="btn btn-warning">Sửa</a></td>
                <td>
                  <form action="/management/user/{{$user->id}}" method="post">
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