@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      @include('management.inc.sidebar')
      <div class="col-md-8">
        <i class="fas fa-hamburger"></i><span class="form-title">Thêm Món Mới</span> 
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
        <form action="/management/items" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="itemName" class="form-label" >Tên Món</label>
            <input type="text" name="name" class="form-control" placeholder="Item..." required oninvalid="this.setCustomValidity('Điền tên món')">
          </div>
          <label for="itemPrice" class="form-label">Giá tiền</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">VNĐ</span>
            </div>
            <input type="text" name="price" class="form-control" aria-label="" required oninvalid="this.setCustomValidity('Điền tên giá tiền')">
            <div class="input-group-append">
            </div>
          </div>
          <label for="ItemImage" class="form-label">Ảnh Món Ăn</label>
          <div class="input-group mb-3">
            <div class="custom-file">
              <input type="file" name="image" class="custom-file-input" id="inputGroupFile01">           
            </div>
          </div>

          <div class="mb-3">
            <label for="Description" class="form-label">Mô tả</label>
            <input type="text" name="description" class="form-control" placeholder="Viết mô tả..." required oninvalid="this.setCustomValidity('Điền mô tả')">
          </div>

          <div class="mb-3">
            <label for="Category" class="form-label">Phân Loại</label>
            <select class="form-control" name="category_id">
              @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary btn-lg">Lưu</button>
        </form>
      </div>
    </div>
  </div>
@endsection