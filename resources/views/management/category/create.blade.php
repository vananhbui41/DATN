@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      @include('management.inc.sidebar')
      <div class="col-md-8">
        <i class="fas fa-align-justify"></i><span class="form-title">Tạo phân loại món ăn</span>
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
        <form action="/management/categories" method="POST">
          @csrf
          <div class="mb-3">
            <label for="categoryName" class="form-label" >Tên phân loại</label>
            <input type="text" name="name" class="form-control" placeholder="Category..." required oninvalid="this.setCustomValidity('Điền Tên Phân Loại')"> 
          </div>
          <button type="submit" class="btn btn-primary btn-lg">Lưu</button>
        </form>
      </div>
    </div>
  </div>
@endsection