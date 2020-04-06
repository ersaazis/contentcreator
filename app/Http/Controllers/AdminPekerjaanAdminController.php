<?php namespace App\Http\Controllers;

use ersaazis\cb\controllers\CBController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPekerjaanAdminController extends CBController {


    public function cbInit()
    {
        $this->setTable("job");
        $this->setPermalink("pekerjaan_admin");
		$this->setPageTitle("Pekerjaan Admin");
		$this->setButtonEdit(false);

        $this->addSelectTable("User","users_id",["table"=>"users","value_option"=>"id","display_option"=>"name","sql_condition"=>""]);
		$this->addSelectTable("Projek","project_id",["table"=>"project","value_option"=>"id","display_option"=>"title","sql_condition"=>""]);
		$this->addDatetime("Created At","created_at")->required(false)->showIndex(false)->showAdd(false)->showEdit(false);
		$this->addDatetime("Updated At","updated_at")->required(false)->showIndex(false)->showAdd(false)->showEdit(false);
		$this->addText("Judul","title")->strLimit(150)->maxLength(255);
		$this->addWysiwyg("Deskripsi","description")->strLimit(150);
		$this->addFile("File","file")->encrypt(true);
		$this->addMoney("Bayaran","fee")->prefix('Rp.')->thousandSeparator(',')->required(false)->showAdd(false)->showEdit(false)->filterable(true);
		$this->addDate("Batas Waktu","expire")->required(false)->showAdd(false)->showEdit(false)->filterable(true);
		$this->addRadio("Status","status")->options(['Belum Dikerjakan'=>'Belum Dikerjakan','Dalam Proses'=>'Dalam Proses','Diterima'=>'Diterima','Ditolak'=>'Ditolak'])->required(false)->showAdd(false)->showEdit(false)->filterable(true);
		$this->setAfterDetailForm(function($row) {
			if($row->status != "Diterima")
            	return view("admin_project/konfirmasi")->with('row',$row)->render();
        });
	}
    public function konfirmasi(Request $request)
	{
		$data=$request->all();
		// dd($data);
		$job=DB::table('job')->find($data['id']);
		if($data['status'] == "Diterima"){
			$user=DB::table('users')->find($data['users_id']);
			DB::table('users')->where('id',$data['users_id'])->update([
				'active_project'=>($user->active_project-1),
				'project_sucess'=>($user->project_sucess+1),
				'fee'=>($user->fee+$job->fee)
			]);
			DB::table('info_masa')->insert([
				'project'=>$job->title,
				'fee'=>$job->fee,
				'info'=>$user->name." Telah Berhasil Menyelesaikan Project ".$job->title." dengan bayaran ".$job->fee
				]);
		}
		DB::table('job')->where('id',$data['id'])->update(['status'=>$data['status']]);
		DB::table('notification')->insert([
			'users_id'=>$data['users_id'],
			'title'=>'Project <a href="'.cb()->getAdminUrl('pekerjaan/detail/'.$job->id).'">'.$job->title.'</a> <b>'.$data['status'].'</b>',
			'description'=>$data['description']
		]);
		return cb()->redirectBack("Berhasil Di Simpan !", "success");
	}
}
