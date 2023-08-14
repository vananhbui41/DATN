@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">      
      @if($errors->any())
      <div class="col-md-12">
        <div class="alert alert-danger">
            <ul>
              @foreach($errors->all() as $error)
                  <li>{{$error}}</li>
              @endforeach
            </ul>
        </div>
      </div>
      @endif
      <div class="col-md-6">
          <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Biểu Đồ</li>
          </ol>
        </nav>
      </div>        
      <div class="col-md-6 float-end">
        <a href="/report" class="btn btn-primary btn-lg">Báo Cáo</a>
      </div>
  </div>   

  <div class="row">
    {{-- @include('report.charts.revenueByTimeChart') --}}
  </div>
</div>
@endsection