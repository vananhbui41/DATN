@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
        @include('management.inc.sidebar')
      <div class="col-md-8">
        <i class="fas fa-align-justify"></i><span class="form-title">Chỉnh Sửa Phân Loại</span> 
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
        <form action="/management/categories/{{$category->id}}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label for="categoryName" class="form-label">Tên</label>
            <input type="text" name="name" value="{{$category->name}}"  class="form-control" placeholder="Nhập tên ..." required oninvalid="this.setCustomValidity('Điền tên phân loại')">
          </div>
          <button type="submit" class="btn btn-primary btn-lg">Lưu</button>
        </form>
      </div>
    </div>
  </div>
@endsection