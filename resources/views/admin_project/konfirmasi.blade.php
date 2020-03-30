<div class="box box-default">
    <div class="box-header with-border">
        <h1 class="box-title"><i class="fa fa-eye"></i> Konfirmasi</h1>
    </div>
    <div class="box-body">
        <form action="{{cb()->getAdminUrl('pekerjaan_admin/konfirmasi')}}" method="POST">
            @csrf
            <div class="form-group " id="form-group-title">
                <label> Keterangan</label>
                <div class="row">
                    <div class="col-sm-12">
                        <textarea name="description" cols="30" rows="5" class="form-control" ></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12">
                            
                        <input type="hidden" class="btn btn-primary" name="users_id" value="{{$row->users_id}}">
                        <input type="hidden" class="btn btn-primary" name="id" value="{{$row->primary_key}}">
                        <input type="submit" class="btn btn-primary" name="status" value="Diterima">
                        <input type="submit" class="btn btn-danger" name="status" value="Ditolak">
                    </div>
                </div>
            </div>            
        </form>
    </div>
</div>