<div class="box box-default">
    <div class="box-header with-border">
        <h1 class="box-title"><i class="fa fa-briefcase"></i> Detail Project</h1>
    </div>
    <div class="box-body" style="padding:10px;margin:10px;border:1px solid #ccc">
        <h4>{!! $row->title !!}</h4>
        <hr style="margin-top:0px">
        {!! $row->description !!}
    </div>
    <br>
</div>
<div class="box box-default">
    <div class="box-header with-border">
        <h1 class="box-title"><i class="fa fa-briefcase"></i> Gambar Hasil</h1>
    </div>
    <div class="box-body" style="padding:10px;margin:10px;border:1px solid #ccc">
        <img src="{{url($image)}}" alt="" width="50%">
    </div>
    <br>
</div>