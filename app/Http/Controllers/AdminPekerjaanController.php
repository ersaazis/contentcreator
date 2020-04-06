<?php namespace App\Http\Controllers;

use DateTime;
use ersaazis\cb\controllers\CBController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminPekerjaanController extends CBController {


    public function cbInit()
    {
        $this->setTable("job");
        $this->setPermalink("pekerjaan");
        $this->setPageTitle("Pekerjaan");
        $this->setButtonDelete(false);
		$this->setButtonAdd(false);
		$this->setButtonEdit(false);

		
        $this->addActionButton("Edit",function($row){
            return cb()->getAdminUrl('pekerjaan/edit/'.$row->primary_key);
        },function($row) {
		    return $row->status != "Diterima";
        },'fa fa-pencil','success');
		
        $this->addSelectTable("User","users_id",["table"=>"users","value_option"=>"id","display_option"=>"name","sql_condition"=>""])->showEdit(false);
		$this->addSelectTable("Projek","project_id",["table"=>"project","value_option"=>"id","display_option"=>"title","sql_condition"=>""])->showEdit(false);
		$this->addDatetime("Created At","created_at")->required(false)->showIndex(false)->showAdd(false)->showEdit(false);
		$this->addDatetime("Updated At","updated_at")->required(false)->showIndex(false)->showAdd(false)->showEdit(false);
		$this->addText("Judul","title")->strLimit(150)->maxLength(255);
		$this->addWysiwyg("Deskripsi","description")->strLimit(150);
		$this->addFile("File","file")->encrypt(true)->showIndex(false);
		$this->addMoney("Bayaran","fee")->filterable(true)->prefix('Rp.')->thousandSeparator(',')->required(false)->showAdd(false)->showEdit(false)->filterable(true);
		$this->addDate("Batas Waktu","expire")->required(false)->showAdd(false)->showEdit(false)->filterable(true);
		$this->addRadio("Status","status")->options(['Belum Dikerjakan'=>'Belum Dikerjakan','Dalam Proses'=>'Dalam Proses','Diterima'=>'Diterima','Ditolak'=>'Ditolak'])->required(false)->showAdd(false)->showEdit(false)->filterable(true);
		$this->hookBeforeUpdate(function($data, $id) {
			$data['status']="Dalam proses";
			unset($data['users_id']);
			unset($data['project_id']);
			unset($data['fee']);
			unset($data['expire']);
			return $data;
		});

		$this->setBeforeIndexTable('
		<div class="callout callout-info">
			<p>Anda hanya bisa mengambil <b>MAX 3</b> proyek, jika ingin menambah lagi, silakan selesaikan terlebih dahulu proyek yang diambil sebelumnya.</p>
		</div>
		');
		$this->setBeforeDetailForm(function($row) {
			if($row->users_id != cb()->session()->id()) return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));
			$project = DB::table('project')->find($row->project_id);
			return '
			<div class="box box-default">
				<div class="box-header with-border">
					<h1 class="box-title"><i class="fa fa-briefcase"></i> Detail Project</h1>
				</div>
				<div class="box-body" style="padding:10px;margin:10px;border:1px solid #ccc">
					<h4>'.$project->title.'</h4>
					<hr style="margin-top:0px">
					'.$project->description.'
				</div>
				<br>
			</div>
			';
        });
		$this->hookIndexQuery(function($query) {
            $query->where("users_id",cb()->session()->id());
            $query->orderBy("expire","ASC");
            return $query;
        });
	}
	public function getproject($id){
		if($users = DB::table('users')->find(cb()->session()->id()) and $project = DB::table('project')->find($id)){
			if($users->active_project < 3 and $project->taken < $project->total){
				$project->taken+=1;
				DB::table('project')->where('id',$id)->update(['taken'=>$project->taken]);

				$users->active_project+=1;
				DB::table('users')->where('id',cb()->session()->id())->update(['active_project'=>$users->active_project]);

				$date = new DateTime('+'.$project->work_time.' day');
				DB::table('job')->insert([
					'users_id'=>cb()->session()->id(),
					'project_id'=>$id,
					'title'=>$project->title,
					'description'=>"Untuk Konten Instagram refesensi captionya bisa dimasukan disini",
					'fee'=>$project->fee,
					'expire'=>$date,
					'status'=>"Belum Dikerjakan"
				]);
				return cb()->redirect(cb()->getAdminUrl('pekerjaan'), "Projek Berhasil Diambil !", "success");
			}
			else return cb()->redirectBack("Sudah ada yang mengambil projek ini, atau anda telah melebihi maximum pengambilan projek silakan kerjakan projek yang telah diambil sebelumnya", "warning");

		}
		else return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));
	}
	
    public function getEdit($id)
    {
        if(!module()->canUpdate()) return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));

        $data = [];
		$data['row'] = DB::table('job')->find($id);
		if($data['row']->status == "Diterima") return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));
        if($data['row']->users_id != cb()->session()->id()) return cb()->redirect(cb()->getAdminUrl(),cbLang("you_dont_have_privilege_to_this_area"));
        $data['project'] = DB::table('project')->find($data['row']->project_id);
        $data['page_title'] = 'Pekerjaan : '.cbLang('edit');
        $data['action_url'] = module()->editSaveURL($id);
        return view('pekerjaan/editProject', array_merge($data));
    }
}
