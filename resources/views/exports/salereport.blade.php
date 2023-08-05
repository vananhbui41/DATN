<table>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Receipt ID</th>
                  <th>Date Time</th>
                  <th>Table</th>
                  <th>Staff</th>
                  <th>Total Amount</th>
                </tr>
              </thead>
              <tbody>
                @php 
                  $countSale = 1;
                @endphp 
                @foreach($sales as $sale)
                  <tr>
                    <td>{{$countSale++}}</td>
                    <td>{{$sale->id}}</td>
                    <td>{{date("m/d/Y H:i:s", strtotime($sale->updated_at))}}</td>
                    <td>{{$sale->table_name}}</td>
                    <td>{{$sale->user_name}}</td>
                    <td>{{$sale->total_price}}</td>
                  </tr>
                  <tr >
                    <th></th>
                    <th>Item ID</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Price</th>
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
                <tr>
                  <td colspan="5">Total Amount from {{$dateStart}} to {{$dateEnd}}</td>
                  <td>{{number_format($totalSale, 2)}}</td>
                </tr>
              </tbody>
            </table>