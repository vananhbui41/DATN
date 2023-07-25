@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      @include('management.inc.sidebar')
      <div class="col-md-8">
        <i class="fas fa-hamburger"></i>Edit a Item
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
        <form action="/management/items/{{$item->id}}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="itemName">Tên món ăn</label>
            <input type="text" name="name" value="{{$item->name}}" class="form-control" placeholder="Nhập tên ...">
          </div>
          <label for="itemPrice">Giá tiền</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">VNĐ</span>
            </div>
            <input type="text" name="price" value="{{$item->price}}" class="form-control" aria-label="">
          </div>
          <label for="ItemImage">Ảnh Món Ăn</label>
          <div class="input-group mb-3">
            <div class="custom-file">
              <input type="file" name="image" class="custom-file-input" id="inputGroupFile01">          
            </div>
          </div>

          <div class="form-group">
            <label for="Description">Mô tả</label>
            <input type="text" name="description" value="{{$item->description}}" class="form-control" placeholder="Mô tả...">
          </div>

          <div class="form-group">
            <label for="Category">Phân Loại</label>
            <select class="form-control" name="category_id">
              @foreach ($categories as $category)
                <option value="{{$category->id}}" {{$item->category_id === $category->id ? 'selected': ''}}>{{$category->name}}</option>

              @endforeach
            </select>
          </div>

          <button type="submit" class="btn btn-warning">Lưu</button>
        </form>
      </div>
    </div>
  </div>
@endsection