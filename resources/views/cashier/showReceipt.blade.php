<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restuarnt App - Receipt - SaleID : {{$sale->id}}</title>
  <link type="text/css" rel="stylesheet" href="{{asset('/css/receipt.css')}}" media="all" >
  <link type="text/css" rel="stylesheet" href="{{asset('/css/no-print.css')}}" media="print" >
</head>
<body>
  <div id="wrapper">
    <div id="receipt-header">
      <h3 id="resturant-name">Buntim118</h3>
      <p>Address: 118 Hai Bà Trưng, Nam Định</p>
      <p>Tel: 0912345678</p>
      <p>Thời gian: {{$sale->created_at}}</p>
      <p>Reference Receipt: <strong>{{$sale->id}}</strong></p>
    </div>
    <div id="receipt-body">
      <table class="tb-sale-detail">
        <thead>
          <tr>
            <th>#</th>
            <th>Món</th>
            <th>Số Lượng</th>
            <th>Đơn Giá</th>
            <th>Tổng</th>
          </tr>
        </thead>
        <tbody>
          {{$saleDetailId = 1}}
          @foreach($saleDetails as $saleDetail)
            <tr>
              <td width="30">{{$saleDetailId}}</td>
              <td width="180">{{$saleDetail->item_name}}</td>
              <td width="50">{{$saleDetail->quantity}}</td>
              <td width="55">{{$saleDetail->item_price}}</td>
              <td width="65">{{$saleDetail->item_price * $saleDetail->quantity}}</td>
            </tr>
          {{$saleDetailId++}}
          @endforeach
        </tbody>
      </table>
      <table class="tb-sale-total">
        <tbody>
          <tr>
            <td>Tổng</td>
            <td></td>
            <td>{{number_format($sale->total_price)}} VNĐ</td>
          </tr>
          <tr>
            <td colspan="2">Phương Thức Thanh Toán: </td>
            <td colspan="2">
              @if ($sale->payment_type == 'cash') 
                Tiền mặt
              @else
                Chuyển khoản
              @endif
            </td>
          </tr>
          <tr>
            <td colspan="2">Số tiền đã trả</td>
            <td colspan="2">{{number_format($sale->total_recieved)}}</td>
          </tr>
          <tr>
            <td colspan="2">Tiền thừa</td>
            <td colspan="2">{{number_format($sale->chang)}}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div id="receipt-footer">
      <p>Cảm Ơn!!!</p>
    </div>
    <div id="buttons">
      <a href="/cashier">
        <button class="btn btn-back">
          Quay Lại Trang Bán Hàng
        </button>
      </a>
      <button class="btn btn-print" type="button" onclick="window.print(); return false;">
        In Hóa Đơn
      </button>
    </div>
  </div>
</body>
</html>