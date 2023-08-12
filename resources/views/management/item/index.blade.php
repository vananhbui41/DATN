@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      @include('management.inc.sidebar')
      <div class="col-md-8">
        <i class="fas fa-hamburger"></i><span class="form-title"> Món Ăn </span>
        <a href="/management/items/create" class="btn btn-success btn-sm float-end"><i class="fas fa-plus"></i> Tạo món mới</a>
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
              <th scope="col">Tên</th>
              <th scope="col">Giá</th>
              <th scope="col">Ảnh</th>
              <th scope="col">Mô tả</th>
              <th scope="col">Phân Loại</th>
              <th scope="col">Sửa</th>
              <th scope="col">Xóa</th>
            </tr>
          </thead>
          <tbody>
            @foreach($items as $item)
              <tr class="table-light">
                <td>{{$item->id}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->price}}</td>
                <td>
                  <img src="{{asset('item_images')}}/{{$item->image}}" alt="{{$item->name}}" width="120px" height="120px" class="img-thumbnail">
                </td>
                <td>{{$item->description}}</td>
                <td>{{$item->category->name}}</td>
                <td><a href="/management/items/{{$item->id}}/edit" class="btn btn-warning">Edit</a></td>
                <td>
                  <form action="/management/items/{{$item->id}}" method="post">
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