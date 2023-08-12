@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      @include('management.inc.sidebar')
      <div class="col-md-8">
        <i class="fas fa-chair"></i><span class="form-title"> Sửa thông tin bàn </span>
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
        <form action="/management/tables/{{$table->id}}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label for="tableName" class="form-label">Tên Bàn</label>
            <input type="text" name="name" value="{{$table->name}}" class="form-control" placeholder="Nhập tên..." required oninvalid="this.setCustomValidity('Điền tên bàn')">
          </div>
          <button type="submit" class="btn btn-warning btn-lg">Lưu</button>
        </form>
      </div>
    </div>
  </div>
@endsection