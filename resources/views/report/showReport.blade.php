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
            <li class="breadcrumb-item"><a href="/report">Report</a></li>
            <li class="breadcrumb-item active" aria-current="page">Result</li>
          </ol>
        </nav>
      </div>
      <div class="col-md-6">
        <a href="/report/charts" class="btn btn-primary">Biểu đồ</a> 
      </div>
    </div>
    <div class="row" id="filter">
      <form action="/report/show" method="GET">
        <label style="font-size: 20px; font-weight: bold">Danh Sách Order</label>
        <div class="row">
          <div class="col mb-3">
              <label for="date-start" class="form-label">Start</label>
              <input id="date-start" class="form-control" type="date" name="dateStart"/>
              <span id="startDateSelected"></span>
          </div>
          <div class="col mb-3">
              <label for="date-end" class="form-label">End</label>
              <input id="date-end" class="form-control" type="date" name="dateEnd"/>
              <span id="endDateSelected"></span>
          </div>
        </div>
        <div class="row">
          <div class="col mb-3">
            <label for="Table" class="form-label">Bàn</label>
            <select class="form-control" name="table_id">
              <option value="">Chọn bàn</option>
              @foreach ($tables as $table)
                <option value="{{$table->id}}">{{$table->name}}</option>
              @endforeach
            </select>           
          </div>
          <div class="col mb-3">
            <label for="User" class="form-label">Nhân viên</label>
            <select class="form-control" name="user_id">
              <option value="">Chọn Nhân Viên</option>
              @foreach ($users as $user)
                <option value="{{$user->id}}">{{$user->name}}</option>
              @endforeach
            </select>           
          </div>
        </div>
        <input class="btn btn-primary" type="submit" value="Xem Báo Cáo" id="show-report">

      </form>
    </div>
    <div class="row">
        <div class="col-md-12">
          @if($sales->count() > 0)
            <div class="alert alert-success" role="alert">
              <p>Từ ngày {{$dateStart}} đến {{$dateEnd}} </p>
              {{-- @if(isset($table))
              <p>Bàn: {{$table->name}} </p>
              @endif --}}
              <p style="font-weight: bold">Tổng doanh thu: {{number_format($totalSale)}} VNĐ</p>
              <p style="font-weight: bold">Tổng số đơn: {{$sales->total()}}</p>
            </div>
            <table class="table">
              <thead class="table-primary">
                <tr class="bg-primary text-light">
                  <th scope="col">#</th>
                  <th scope="col">ID Đơn</th>
                  <th scope="col">Thời Gian Tạo</th>
                  <th scope="col">Bàn</th>
                  <th scope="col">Nhân Viên</th>
                  <th scope="col">Tổng Tiền</th>
                </tr>
              </thead>
              <tbody>
                @php 
                  $countSale = ($sales->currentPage() - 1) * $sales->perPage() + 1;
                @endphp 
                @foreach($sales as $sale)
                  <tr class="bg-primary text-light">
                    <td>{{$countSale++}}</td>
                    <td>{{$sale->id}}</td>
                    <td>{{date("m/d/Y H:i:s", strtotime($sale->updated_at))}}</td>
                    <td>{{$sale->table_name}}</td>
                    <td>{{$sale->user_name}}</td>
                    <td>{{$sale->total_price}}</td>
                  </tr>
                  <tr >
                    <th></th>
                    <th>ID Món</th>
                    <th>Món</th>
                    <th>Số Lượng</th>
                    <th>Đơn Giá</th>
                    <th>Thành Tiền</th>
                  </tr>
                  @foreach($sale->saleDetails as $saleDetail)
                    <tr>
                      <td></td>
                      <td>{{$saleDetail->item_id}}</td>
                      <td>{{$saleDetail->item_name}}</td>
                      <td>{{$saleDetail->quantity}}</td>
                      <td>{{$saleDetail->item_price}}</td>
                      <td>{{$saleDetail->item_price * $saleDetail->quantity}}</td>
                    </tr>
                  @endforeach
                @endforeach
              </tbody>
            </table>
   
            {{$sales->appends($_GET)->links()}}

            <form action="/report/show/export" method="get">
              <input type="hidden" name="dateStart" value="{{$dateStart}}" >
              <input type="hidden" name="dateEnd" value="{{$dateEnd}}" >
              <input type="submit" name="btn btn-warning" value="Xuất báo cáo thành file Exel">
            </form>

          @else
            <div class="alert alert-danger" role="alert">
              Không có order nào phù hợp
            </div>
          @endif
        </div>
    </div>
  </div>

@endsection