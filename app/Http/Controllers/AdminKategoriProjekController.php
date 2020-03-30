<?php namespace App\Http\Controllers;

use ersaazis\cb\controllers\CBController;

class AdminKategoriProjekController extends CBController {


    public function cbInit()
    {
        $this->setTable("kategori_project");
        $this->setPermalink("kategori_projek");
        $this->setPageTitle("Kategori Projek");

        $this->addDatetime("Created At","created_at")->required(false)->showAdd(false)->showEdit(false);
		$this->addDatetime("Updated At","updated_at")->required(false)->showAdd(false)->showEdit(false);
		$this->addText("Kategori","kategori")->strLimit(150)->maxLength(255);
		$this->addText("Jumlah","jumlah")->required(false)->showAdd(false)->showEdit(false)->strLimit(150)->maxLength(255);
		

    }
}
