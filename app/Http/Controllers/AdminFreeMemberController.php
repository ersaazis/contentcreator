<?php namespace App\Http\Controllers;

use ersaazis\cb\controllers\CBController;

class AdminFreeMemberController extends CBController {


    public function cbInit()
    {
        $this->setTable("users");
        $this->setPermalink("free_member");
        $this->setPageTitle("Free Member");

        $this->addText("Name","name")->required(false)->showAdd(false)->showEdit(false)->strLimit(150)->maxLength(255);
		$this->addEmail("Email","email")->required(false)->showAdd(false)->showEdit(false);
		$this->addMoney("Bayaran","fee")->prefix('Rp.')->thousandSeparator(',')->required(false)->showAdd(false)->showEdit(false)->filterable(true);
		$this->addText("Active Project","active_project")->required(false)->showAdd(false)->showEdit(false)->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Project Sucess","project_sucess")->required(false)->showAdd(false)->showEdit(false)->filterable(true)->strLimit(150)->maxLength(255);
		$this->addText("Project Fail","project_fail")->required(false)->showAdd(false)->showEdit(false)->filterable(true)->strLimit(150)->maxLength(255);
		

    }
}
