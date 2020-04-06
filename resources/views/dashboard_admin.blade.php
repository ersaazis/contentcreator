@extends('crud::themes.adminlte.layout.layout')
@section('content')
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{$project}}</h3>
                    <p>Projek</p>
                </div>
                <div class="icon">
                    <i class="fa fa-file-text"></i>
                </div>
            </div>
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{$project_success}}</h3>
                    <p>Yang Telah Dikerjakan</p>
                </div>
                <div class="icon">
                    <i class="fa fa-file-text"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>Rp. {{number_format($all_payment)}}</h3>
                    <p>Semua Pembayaran</p>
                </div>
                <div class="icon">
                    <i class="fa fa-money"></i>
                </div>
            </div>
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>Rp. {{number_format($all_payment_project)}}</h3>
                    <p>Pembayaran Projek</p>
                </div>
                <div class="icon">
                    <i class="fa fa-money"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green-active">
                <div class="inner">
                    <h3>Rp. {{number_format($req_payment)}}</h3>
                    <p>Request Penarikan</p>
                </div>
                <div class="icon">
                    <i class="fa fa-money"></i>
                </div>
            </div>
            <div class="small-box bg-green-active">
                <div class="inner">
                    <h3>Rp. {{number_format($potential_payment)}}</h3>
                    <p>Potensi Penarikan</p>
                </div>
                <div class="icon">
                    <i class="fa fa-money"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-purple">
                <div class="inner">
                    <h3>{{$job}}</h3>
                    <p>Cek Pekerjaan</p>
                </div>
                <div class="icon">
                    <i class="fa fa-briefcase"></i>
                </div>
            </div>
            <div class="small-box bg-purple">
                <div class="inner">
                    <h3>{{$jum_users}}</h3>
                    <p>User</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h1 class="box-title"><i class="fa fa-users"></i> Top Users</h1>
                </div>
                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        @foreach ($users as $item)
                            <li class="item">
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">{{$item->name}}
                                        <span class="label label-primary  pull-right">{{number_format($item->project_sucess)}} Projek Berhasil</span></a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h1 class="box-title"><i class="fa fa-briefcase"></i> Informasi Project</h1>
                </div>
                <div class="box-body">
                    <ul class="products-list product-list-in-box">
                        @foreach ($info as $item)
                            <li class="item">
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">{{$item->project}}
                                        <span class="label label-primary  pull-right">+ Rp. {{number_format($item->fee)}} ,-</span></a>
                                    <span class="product-description">
                                        {{$item->info}}
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection