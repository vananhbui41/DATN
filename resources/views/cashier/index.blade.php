@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="table-detail"></div>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <button class="btn btn-primary btn-block" id="btn-show-tables">Danh Sách Bàn</button>
            <div id="selected-table"></div>
            <div id="order-detail"></div>
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
<script>
    $(document).ready(function() {
        // make table-detail hidden by default
        $("#table-detail").hide();

        //show all tables when a client click on the button
        $("#btn-show-tables").click(function(){
            if($("#table-detail").is(":hidden")){
                $.get("/cashier/getTable", function(data){
                $("#table-detail").html(data);
                $("#table-detail").slideDown('fast');
                $("#btn-show-tables").html('Ẩn Danh Sách Bàn').removeClass('btn-primary').addClass('btn-danger');
            })
            }else{
                $("#table-detail").slideUp('fast');
                $("#btn-show-tables").html('Danh Sách Bàn').removeClass('btn-danger').addClass('btn-primary');
            }
        });

        // Get item by category
        $(".nav-link").click(function(){
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
    });
</script>
@endsection
