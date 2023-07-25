@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Chọn Chức Năng</div>

                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-sm-4">
                            <a href="/management">
                                <h4>Quản Lý</h4>
                                <img width="50px" src="{{asset('images/management.png')}}"/>
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="/cashier">
                                <h4>Bán Hàng</h4>
                                <img width="50px" src="{{asset('images/cashier.png')}}"/>
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="/report">
                                <h4>Báo Cáo</h4>
                                <img width="50px" src="{{asset('images/dashboard.png')}}"/>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
