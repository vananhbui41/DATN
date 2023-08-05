@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Chọn Chức Năng</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row text-center">
                        @if(Auth::user()->checkAdmin())
                        <div class="col-sm-4">
                            <a href="/management">
                                <h4>Quản Lý</h4>
                                <img width="50px" src="{{asset('images/management.png')}}"/>
                            </a>
                        </div>
                        @endif
                        <div class="col-sm-4">
                            <a href="/cashier">
                                <h4>Bán Hàng</h4>
                                <img width="50px" src="{{asset('images/cashier.png')}}"/>
                            </a>
                        </div>
                        @if(Auth::user()->checkAdmin())
                        <div class="col-sm-4">
                            <a href="/report">
                                <h4>Báo Cáo</h4>
                                <img width="50px" src="{{asset('images/dashboard.png')}}"/>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
