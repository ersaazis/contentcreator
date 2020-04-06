<?php namespace App\Http\Controllers;

use ersaazis\cb\controllers\CBController;
use Illuminate\Support\Facades\DB;

class AdminProjekController extends CBController {


    public function cbInit()
    {
        $this->setTable("project");
        $this->setPermalink("projek");
        $this->setPageTitle("Projek");
        $this->setButtonDelete(false);
        $this->setButtonAdd(false);
        $this->setButtonEdit(false);
        $this->setButtonDetail(false);
		$this->addActionButton("Ambil Projek",function($row){
            return cb()->getAdminUrl('projek/detail/'.$row->primary_key);
        },null,'fa fa-pencil','primary');
        $this->addSelectTable("Kategori Projek","kategori_project_id",["table"=>"kategori_project","value_option"=>"id","display_option"=>"kategori","sql_condition"=>""])->filterable(true);
		$this->addDatetime("Created At","created_at")->required(false)->showIndex(false)->showAdd(false)->showEdit(false);
		$this->addDatetime("Updated At","updated_at")->required(false)->showIndex(false)->showAdd(false)->showEdit(false);
		$this->addText("Judul Projek","title")->strLimit(150)->maxLength(255);
		$this->addWysiwyg("Dekripsi Projek","description")->strLimit(150);
		$this->addNumber("Total Projek","total")->filterable(true);
		$this->addNumber("Projek Diambil","taken")->required(false)->showAdd(false)->showEdit(false)->filterable(true);
		$this->addNumber("Waktu Pengerjaan (Hari)","work_time")->required(false)->showAdd(false)->showEdit(false)->filterable(true);
		$this->addMoney("Bayaran","fee")->filterable(true)->prefix('Rp.')->thousandSeparator(',');
        $this->setAfterDetailForm(function($row) {
            // $row contain detail object variable
            return '<a href="'.cb()->getAdminUrl('getproject/'.$row->primary_key).'" class="btn btn-primary">Ambil Projek</a>';
        });

        // To modify default index query
        $this->hookIndexQuery(function($query) {
            $query->where("total",'>', DB::raw("taken"));
            return $query;
        });
    }
}
