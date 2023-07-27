@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="table-detail"></div>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <button class="btn btn-primary btn-block" id="btn-show-tables">Danh Sách Bàn</button>
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
            <div id="list-menu" class="row mt-2"></div>
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
    });
</script>
@endsection
