@extends('crud::themes.adminlte.layout.layout')
@section('content')
    <div class="callout callout-info">
        <p>Apa bila ada masalah jangan ragu menghubungi kami. WhatsApp <a href="https://wa.me/6289656217609" target="_blank">0896 5621 7609</a></p>
    </div>
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{$project_active}}</h3>
                <p>Projek Yang Aktif</p>
                <small>(Maximal 3 Projek Aktif )</small>
            </div>
            <div class="icon">
                <i class="fa fa-file-text"></i>
            </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
            <div class="inner">
                <h3>{{$user->project_fail}}</h3>
                <p>Projek Yang gagal</p>
            </div>
            <div class="icon">
                <i class="fa fa-file-text"></i>
            </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green-active">
            <div class="inner">
                <h3>{{$user->project_sucess}}</h3>
                <p>Projek Yang Berhasil</p>
            </div>
            <div class="icon">
                <i class="fa fa-file-text"></i>
            </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-purple">
            <div class="inner">
                <h3>Rp. {{number_format($user->fee)}}</h3>
                <p>Bayaran</p>
                <small>(minimal penarikan Rp.500.000,-)</small>
            </div>
            <div class="icon">
                <i class="fa fa-money"></i>
            </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @foreach ($notif as $item)
            <div class="callout callout-info">
                <big>{!! $item->title !!}</big>
                <p>{!! $item->description !!}</p>
            </div>
            @endforeach     
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h1 class="box-title"><i class="fa fa-money"></i> Penarikan</h1>
                </div>
                <div class="box-body">
                    <form action="{{cb()->getAdminUrl('penarikan_uang/penarikan')}}" method="POST">
                        @csrf
                        <div class="form-group " id="form-group-title">
                            <label> Jumlah Penarikan (minimum 500000)</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="number" name="fee" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group " id="form-group-title">
                            <label> Nama Bank</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="text" name="bank" class="form-control">
                                </div>
                            </div>
                        </div>   

                        <div class="form-group " id="form-group-title">
                            <label> Nomor Rekening</label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="text" name="bank_number" class="form-control">
                                </div>
                            </div>
                            <small>* (Atas Nama Rekening, Wajib Sama Dengan Nama Akun)</small>
                        </div>  
                        <div class="form-group " id="form-group-title">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="submit" class="btn btn-primary" name="status" value="Kirim">
                                </div>
                            </div>
                        </div>
                    </form>
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