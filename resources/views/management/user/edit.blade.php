@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      @include('management.inc.sidebar')
      <div class="col-md-8">
        <i class="fas fa-user"></i><span class="form-title"> Sửa Thông Tin Nhân Viên </span>
        <hr>
        @if($errors->any())
          <div class="alert alert-danger">
              <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
              </ul>
          </div>
        @endif
        <form action="/management/users/{{$user->id}}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label class="form-label"for="name">Tên</label>
            <input type="text" name="name" value="{{$user->name}}" class="form-control" placeholder="Name..." required oninvalid="this.setCustomValidity('Điền tên nhân viên')">
          </div>
          <div class="mb-3">
            <label class="form-label"for="email">Email</label>
            <input type="email" name="email" value="{{$user->email}}" class="form-control" placeholder="Email..." required oninvalid="this.setCustomValidity('Điền email')">
          </div>
          <div class="mb-3">
            <label class="form-label"for="password">Mật Khẩu</label>
            <input type="password" name="password" class="form-control" placeholder="Password..." >
          </div>
          <div class="mb-3">
            <label class="form-label"for="Role">Chức vụ</label>
            <select name="role" class="form-control">
              <option value="admin" {{$user->role == 'admin' ? 'selected':''}}>Quản lý</option>
              <option value="cashier" {{$user->role == 'cashier' ? 'selected':''}}>Nhân viên</option>
            </select>
          </div>
        
          <button type="submit" class="btn btn-warning btn-lg">Lưu</button>
        </form>
      </div>
    </div>
  </div>
@endsection