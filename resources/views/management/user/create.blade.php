@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      @include('management.inc.sidebar')
      <div class="col-md-8">
        <i class="fas fa-user"></i> <span class="form-title">Thêm Nhân Viên</span>
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
        <form action="/management/users" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label"for="name">Họ Và Tên</label>
            <input type="text" name="name" class="form-control" placeholder="Tên..." required oninvalid="this.setCustomValidity('Điền tên nhân viên')">
          </div>
          <div class="mb-3">
            <label class="form-label"for="email">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Email..." required oninvalid="this.setCustomValidity('Điền tên email')">
          </div>
          <div class="mb-3">
            <label class="form-label"for="password">Mật Khẩu</label>
            <input type="password" name="password" class="form-control" placeholder="Mật Khẩu (tối thiểu 8 kí tự)" required oninvalid="this.setCustomValidity('Điền tên mật khẩu tối thiểu 8 kí tự')">
          </div>
          <div class="mb-3">
            <label class="form-label"for="Role">Chức vụ</label>
            <select name="role" class="form-control">
              <option value="admin">Quản lý</option>
              <option value="cashier">Nhân viên</option>
            </select>
          </div>
        
          <button type="submit" class="btn btn-primary btn-lg">Lưu</button>
        </form>
      </div>
    </div>
  </div>
@endsection