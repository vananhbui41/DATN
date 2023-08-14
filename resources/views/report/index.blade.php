@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        @if($errors->any())
          <div class="alert alert-danger">
              <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
              </ul>
          </div>
        @endif
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Báo cáo</li>
          </ol>
        </nav>
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

    <div class="row" id="report-list">
      <div class="col-md-12">
        @if($sales->count() > 0)
          <table class="table">
            <thead class="table-primary">
              <tr class="bg-primary text-light">
                <th scope="col">#</th>
                <th scope="col">ID</th>
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
              @endforeach
            </tbody>
          </table>
 
          {{$sales->appends($_GET)->links()}}

        @else
          <div class="alert alert-danger" role="alert">
            Không có order nào phù hợp
          </div>
        @endif
      </div>
    </div>
  </div>

  <script type="text/javascript">
      let date-start = document.getElementById('date-start')
      let date-end = document.getElementById('date-end')

      date-start.addEventListener('change',(e)=>{
        let startDateVal = e.target.value
        document.getElementById('startDateSelected').innerText = startDateVal
      })

      date-end.addEventListener('change',(e)=>{
        let endDateVal = e.target.value
        document.getElementById('endDateSelected').innerText = endDateVal
      })  
  </script>
@endsection