@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
        @include('management.inc.sidebar')
      <div class="col-md-8">
        <i class="fas fa-align-justify"></i>Sửa Phân Loại
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
          <div class="form-group">
            <label for="categoryName">Tên</label>
            <input type="text" name="name" value="{{$category->name}}"  class="form-control" placeholder="Nhập tên ...">
          </div>
          <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
      </div>
    </div>
  </div>
@endsection