@extends('layouts.app')

@section('content')
<div class="container">
  @if($errors->any())
    <div class="row">
      <div class="col-md-12">
          <div class="alert alert-danger">
              <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
              </ul>
          </div>       
      </div>
    </div>
    @endif
    <div class="row">
      <div class="col-md-6">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item"><a href="/report">Báo Cáo</a></li>
            <li class="breadcrumb-item active" aria-current="page">Biểu Đồ</li>
          </ol>
        </nav>
      </div>
      <div class="col-md-6">
        <a href="/report/show" class="btn btn-primary">Báo Cáo</a> 
      </div>
    </div>
  <div class="row" id="filter">
    <form action="/report/charts" method="GET">
      <div class="row">
        <div class="col mb-3">
            <input id="date-start" class="form-control" type="date" name="dateStart"/>
            <span id="startDateSelected"></span>
        </div>
        <div class="col mb-3">
            <input id="date-end" class="form-control" type="date" name="dateEnd"/>
            <span id="endDateSelected"></span>
        </div>
        <div class="col mb-3" style="align-self: center">
            <input class="btn btn-primary" type="submit" value="Lọc" id="show-report">
        </div>
      </div>
    </form>
  </div>
  <div class="row" style="margin-top: 20px">
    @include('report.charts.revenueByTimeChart')
  </div>
  <div class="row" style="margin-top: 50px">
    @include('report.charts.revenueByTable')
  </div>
</div>
@endsection