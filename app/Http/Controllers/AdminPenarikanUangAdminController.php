<?php namespace App\Http\Controllers;

use ersaazis\cb\controllers\CBController;
use Illuminate\Support\Facades\DB;

class AdminPenarikanUangAdminController extends CBController {


    public function cbInit()
    {
        $this->setTable("payment");
        $this->setPermalink("penarikan_uang_admin");
        $this->setPageTitle("Penarikan Uang Admin");
        $this->setButtonEdit(false);
        $this->setButtonDelete(false);

        $this->addActionButton("Edit",function($row){
            return cb()->getAdminUrl('penarikan_uang_admin/edit/'.$row->primary_key);
        },function($row) {
		    return $row->status == "Dalam Proses";
        },'fa fa-pencil','success');

        $this->addActionButton("Delete",function($row){
            return cb()->getAdminUrl('penarikan_uang_admin/delete/'.$row->primary_key);
        },function($row) {
		    return $row->status == "Dalam Proses";
        },'fa fa-trash','danger',true);

        $this->addSelectTable("User","users_id",["table"=>"users","value_option"=>"id","display_option"=>"name","sql_condition"=>""]);
		$this->addMoney("Jumlah Penarikan","fee")->prefix('Rp.')->thousandSeparator(',');
		$this->addText("Nama Bank","bank")->strLimit(150)->maxLength(255);
		$this->addText("Nomor Rekening Bank","bank_number")->strLimit(150)->maxLength(255);
		$this->addImage("Bukti Transfer","prove")->encrypt(true)->required(false);
		$this->addSelectOption("Status","status")->options(['Dalam Proses'=>'Dalam Proses','Selesai'=>'Selesai','Ditolak'=>'Ditolak'])->filterable(true);
		$this->addWysiwyg("Information","information")->strLimit(150)->required(false);
		$this->addDatetime("Created At","created_at")->required(false)->showIndex(false)->showAdd(false)->showEdit(false);
		$this->addDatetime("Updated At","updated_at")->required(false)->showIndex(false)->showAdd(false)->showEdit(false);
        $this->hookBeforeInsert(function($data) {
            $user=DB::table('users')->find($data['users_id']);
            $fee=$user->fee;
            if($data['fee'] <= $fee){
                DB::table('users')->where('id',$data['users_id'])->update(['fee'=>$fee-$data['fee']]);
		        return $data;
            }
            else return [];
        });
        $this->hookBeforeUpdate(function($data, $id) {
			if($data['status'] == "Ditolak"){
                DB::table('notification')->insert([
                    'users_id'=>$data['users_id'],
                    'title'=>'Penarikan uang sebesar '.$data['fee'].' kami tolak',
                    'description'=>$data['information']
                ]);
                $user=DB::table('users')->find($data['users_id']);
                DB::table('users')->where('id',$data['users_id'])->update([
                    'fee'=>$user->fee+$data['fee']
                ]);
            }
            elseif($data['status'] == "Selesai") {
                DB::table('notification')->insert([
                    'users_id'=>$data['users_id'],
                    'title'=>'Penarikan uang sebesar '.$data['fee'].' berhasil',
                    'description'=>$data['information']
                ]);
                $user=DB::table('users')->find($data['users_id']);
                DB::table('info_masa')->insert([
                    'project'=>"Penarikan Uang",
                    'fee'=>$data['fee'],
                    'info'=>$user->name." Telah Berhasil Melakukan Penarikan uang"
                ]);
            }
			return $data;
		});

    }
}
