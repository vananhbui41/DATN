@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      @include('management.inc.sidebar')
      <div class="col-md-8">
        <i class="fas fa-align-justify"></i><span class="form-title"> Phân loại món ăn </span>
        <a href="/management/categories/create " class="btn btn-success btn-sm float-end">
          <i class="fas fa-plus"></i> 
          Tạo Phân Loại Món Ăn Mới
        </a>
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
              <th scope="col">Sửa</th>
              <th scope="col">Xóa</th>
            </tr>
          </thead>
          <tbody>
            @foreach($categories as $category)
              <tr>
                <th scope="row">{{$category->id}}</th>
                <td>{{$category->name}}</td>
                <td>
                  <a href="/management/categories/{{$category->id}}/edit" class="btn btn-warning">Sửa</a>
                </td>
                <td>
                <form action="/management/categories/{{$category->id}}" method="post">
                  @csrf
                  @method('DELETE')
                  <input type="submit" value="Xóa" class="btn btn-danger">
                </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        {{$categories->links()}}
      </div>
    </div>
  </div>
@endsection