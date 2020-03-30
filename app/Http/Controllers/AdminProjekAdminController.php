<?php namespace App\Http\Controllers;

use ersaazis\cb\controllers\CBController;
use Illuminate\Support\Facades\DB;

class AdminProjekAdminController extends CBController {


    public function cbInit()
    {
        $this->setTable("project");
        $this->setPermalink("projek_admin");
        $this->setPageTitle("Projek Admin");

        $this->addSelectTable("Kategori Projek","kategori_project_id",["table"=>"kategori_project","value_option"=>"id","display_option"=>"kategori","sql_condition"=>""])->filterable(true);
		$this->addDatetime("Created At","created_at")->required(false)->showIndex(false)->showAdd(false)->showEdit(false);
		$this->addDatetime("Updated At","updated_at")->required(false)->showIndex(false)->showAdd(false)->showEdit(false);
		$this->addText("Judul Projek","title")->strLimit(150)->maxLength(255);
		$this->addWysiwyg("Dekripsi Projek","description")->strLimit(150);
		$this->addNumber("Total Projek","total")->filterable(true);
		$this->addNumber("Waktu Pengerjaan (Hari)","work_time")->filterable(true);
		$this->addNumber("Projek Diambil","taken")->required(false)->showAdd(false)->showEdit(false)->filterable(true);
		$this->addRadio("Status","status")->options(['Aktif'=>'Aktif','Selesai'=>'Selesai'])->required(false)->filterable(true);
		$this->addMoney("Bayaran","fee")->filterable(true)->prefix('Rp.')->thousandSeparator(',');

		$this->addSubModule("Dikerjakan", AdminPekerjaanAdminController::class, "project_id", function ($row) {
			return [
			  "ID"=> $row->primary_key,
			  "Title"=> $row->title
			];
		});
		$this->hookBeforeUpdate(function($data) {
			unset($data['taken']);
			return $data;
		});
		$this->hookBeforeInsert(function($data) {
			$data['taken']=0;
			$data['status'] = "Aktif";
			return $data;
		});
		$this->hookAfterInsert(function($last_insert_id) {
			$project = DB::table('project')->find($last_insert_id);
			$kategori_project = DB::table('kategori_project')->find($project->kategori_project_id);
			$kategori_project->jumlah+=1;
			DB::table('kategori_project')->where('id',$project->kategori_project_id)->update(['jumlah'=>$kategori_project->jumlah]);
		});
    }
}
