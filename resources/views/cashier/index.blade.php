@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="table-detail">

        @foreach ($tables as $table) 
        <div class="col-md-2 mb-3">
        @if($table->status == "available")
        <button class="btn btn-success btn-lg btn-table" style="width: -webkit-fill-available" data-id="{{$table->id}}" data-name="{{$table->name}}"><span>{{$table->name}}</span></button>
        @else 
        <button class="btn btn-danger btn-lg btn-table" style="width: -webkit-fill-available" data-id="{{$table->id}}" data-name="{{$table->name}}"><span>{{$table->name}}</span></button>
        @endif
        </div>
        @endforeach


    </div>
    <div class="row justify-content-center">
        <div class="col-md-5">
            {{-- <button class="btn btn-primary btn-block" id="btn-show-tables">Danh Sách Bàn</button> --}}
            <div id="selected-table"></div>
            <div id="order-detail">
            </div>
        </div>
        <div class="col-md-7">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                @foreach($categories as $category)
                  <a class="nav-item nav-link" data-id="{{$category->id}}" data-toggle="tab">
                    {{$category->name}}
                  </a>
                @endforeach
              </div>
            </nav>
            <div id="list-item" class="row mt-2"></div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Thanh Toán</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h3 class="totalAmount"></h3>
          <h3 class="changeAmount"></h3>
          <h3 class="transferQR"></h3>
          <h3 class="phuThumb"></h3>
          <div class="input-group mb-3 received">
             <div class="input-group-prepend">
              <span class="input-group-text">VNĐ</span>
             </div> 
             <input type="number" id="recieved-amount" class="form-control">
          </div>
          <div class="form-group">
            <label for="payment">Phương Thức Thanh Toán</label>
            <select class="form-control" id="payment-type">
              <option value="cash">Tiền Mặt</option>
              <option value="credit card">Chuyển Khoản</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            <button type="button" class="btn btn-primary btn-save-payment">Tiếp tục</button>
        </div>
      </div>
    </div>
  </div>
<script>
    $(document).ready(function() {
        // make table-detail hidden by default
        // $("#table-detail").hide();

        //show all tables when a client click on the button
        // $("#btn-show-tables").click(function(){
        //     if($("#table-detail").is(":hidden")){
        //         $.get("/cashier/getTable", function(data){
        //         $("#table-detail").html(data);
        //         $("#table-detail").slideDown('fast');
        //         $("#btn-show-tables").html('Ẩn Danh Sách Bàn').removeClass('btn-primary').addClass('btn-danger');
        //     })
        //     }else{
        //         $("#table-detail").slideUp('fast');
        //         $("#btn-show-tables").html('Danh Sách Bàn').removeClass('btn-danger').addClass('btn-primary');
        //     }
        // });

        // Get item by category
        $(".nav-link").click(function(){
            $(this).addClass('active');
            $(".nav-link").not(this).removeClass('active');
            $.get("/cashier/getItemByCategory/"+$(this).data("id"),function(data){
            $("#list-item").hide();
            $("#list-item").html(data);
            $("#list-item").fadeIn('fast');
            });
        })
        var SELECTED_TABLE_ID = "";
        var SELECTED_TABLE_NAME = "";

        // detect button table onclick to show table data
        $("#table-detail").on("click", ".btn-table", function(){
            SELECTED_TABLE_ID = $(this).data("id");
            SELECTED_TABLE_NAME = $(this).data("name");
            $("#selected-table").html('<br><h3>Bàn: '+SELECTED_TABLE_NAME+'</h3><hr>');
            $.get("/cashier/getSaleDetailsByTable/"+SELECTED_TABLE_ID, function(data){
                $("#order-detail").html(data);
            });
        });

        $("#list-item").on("click", ".btn-item", function(){
            if(SELECTED_TABLE_ID == ""){
            alert("Chọn Bàn Trước");
            } else {
                var item_id = $(this).data("id");
                $.ajax({
                    type: "POST",
                    data: {
                        "_token" : $('meta[name="csrf-token"]').attr('content'),
                        "item_id": item_id,
                        "table_id": SELECTED_TABLE_ID,
                        "table_name": SELECTED_TABLE_NAME,
                        "quantity" : 1
                    },
                    url: "/cashier/orderFood",
                    success: function(data){
                        $("#order-detail").html(data);
                    }
                });
            }
        });

        $("#order-detail").on('click', ".btn-confirm-order", function(){
            var SaleID = $(this).data("id");
            $.ajax({
                type: "POST",
                data: {
                    "_token" : $('meta[name="csrf-token"]').attr('content'),
                    "sale_id" : SaleID
                },
                url: "/cashier/confirmOrderStatus",
                success: function(data){
                    $("#order-detail").html(data);
                }
            });
        });

        // delete saledetail
        $("#order-detail").on("click", ".btn-delete-saledetail",function(){
            var saleDetailID = $(this).data("id");
            $.ajax({
                type: "POST",
                data: {
                    "_token" : $('meta[name="csrf-token"]').attr('content'),
                    "saleDetail_id": saleDetailID
                },
                url: "/cashier/deleteSaleDetail",
                success: function(data){
                    $("#order-detail").html(data);
                }
            })

        });

        //increse Item qty
        $("#order-detail").on("click", ".btn-increase-qty",function(){
            var saleDetailID = $(this).data("id");
            $.ajax({
                type: "POST",
                data: {
                    "_token" : $('meta[name="csrf-token"]').attr('content'),
                    "saleDetail_id": saleDetailID
                },
                url: "/cashier/increaseItemQty",
                success: function(data){
                    $("#order-detail").html(data);
                }
            })

        });

        //decrese Item qty
        $("#order-detail").on("click", ".btn-decrease-qty",function(){
            var saleDetailID = $(this).data("id");
            $.ajax({
                type: "POST",
                data: {
                    "_token" : $('meta[name="csrf-token"]').attr('content'),
                    "saleDetail_id": saleDetailID
                },
                url: "/cashier/decreaseItemQty",
                success: function(data){
                    $("#order-detail").html(data);
                }
            })

        });

        // when a user click on the payment button
        $("#order-detail").on("click", ".btn-payment", function(){
            var totalAmout = $(this).attr('data-totalAmount');
            $(".totalAmount").html("Tổng:   " + totalAmout + " VNĐ");
            $("#recieved-amount").val('');
            $(".changeAmount").html('');
            SALE_ID = $(this).data('id');
        });

        // calcuate change
        $("#recieved-amount").keyup(function(){
            var totalAmount = $(".btn-payment").attr('data-totalAmount');
            var recievedAmount = $(this).val();
            var changeAmount = recievedAmount - totalAmount;
            $(".changeAmount").html("Trả lại khách: " + changeAmount + " VNĐ");
        });
        
        // show qr transfer
        $("#payment-type").change(function(){
            var totalAmount = $(".btn-payment").attr('data-totalAmount');
            var saleId = SALE_ID;
            $('.transferQR').html(
            'QR chuyển khoản: <a target="_blank" href="https://img.vietqr.io/image/cake-0912463044-print.png?amount='+totalAmount+'&addInfo=ID'+saleId+'&accountName=Bui%Van%Anh"><span style = "color: #0d6efd; font-size: larger">Ngân Hàng Cake</span></a>');
        });

        // save payment
        $(".btn-save-payment").click(function(){
            var totalAmount = $(".btn-payment").attr('data-totalAmount');
            var recievedAmount = $("#recieved-amount").val();
            if (recievedAmount == '') {
                recievedAmount = totalAmount;
            }
            var paymentType =$("#payment-type").val();
            var saleId = SALE_ID;
            $.ajax({
                type: "POST",
                data: {
                    "_token" : $('meta[name="csrf-token"]').attr('content'),
                    "saleID" : saleId,
                    "recievedAmount" : recievedAmount,
                    "paymentType" : paymentType

                },
                url: "/cashier/savePayment",
                success: function(data){
                    window.location.href= data;
                }
            });
        });
    });
</script>
@endsection
