<?php namespace App\Http\Controllers;

use ersaazis\cb\controllers\CBController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPenarikanUangController extends CBController {


    public function cbInit()
    {

        $this->setTable("payment");
        $this->setPermalink("penarikan_uang");
        $this->setPageTitle("Penarikan Uang");
        $this->setButtonEdit(false);
        $this->setButtonDelete(false);
        $this->setButtonAdd(false);

        $this->addSelectTable("User","users_id",["table"=>"users","value_option"=>"id","display_option"=>"name","sql_condition"=>""])->showIndex(false);
		$this->addMoney("Jumlah Penarikan","fee")->prefix('Rp.')->thousandSeparator('.');
		$this->addText("Nama Bank","bank")->strLimit(150)->maxLength(255);
		$this->addText("Nomor Rekening Bank","bank_number")->strLimit(150)->maxLength(255);
		$this->addImage("Bukti Transfer","prove");
		$this->addSelectOption("Status","status")->options(['Dalam Proses'=>'Dalam Proses','Selesai'=>'Selesai','Ditolak'=>'Ditolak'])->filterable(true);
		$this->addWysiwyg("Information","information")->strLimit(150)->required(false);
		$this->addDatetime("Created At","created_at")->required(false)->showIndex(false)->showAdd(false)->showEdit(false);
		$this->addDatetime("Updated At","updated_at")->required(false)->showIndex(false)->showAdd(false)->showEdit(false);
        
        $this->hookIndexQuery(function($query) {
            $query->where("users_id",cb()->session()->id());
            return $query;
        });
    }

    public function penarikan(Request $request)
    {
        $reqPay=$request->all();

        $user=DB::table('users')->find(cb()->session()->id());
        if($user->fee >= $reqPay['fee'] and $reqPay['fee'] >= 500000){
            // dd($request->all());

            DB::table('users')->where('id',cb()->session()->id())->update([
                'fee'=>$user->fee-$reqPay['fee']
            ]);

            DB::table('payment')->insert([
                'users_id'=>cb()->session()->id(),
                'fee'=>$reqPay['fee'],
                'bank'=>$reqPay['bank'],
                'bank_number'=>$reqPay['bank_number'],
            ]);
            return cb()->redirect(cb()->getAdminUrl('penarikan_uang'),"Berhasil, Penarikan Uang Anda Akan Segera Kami Proses", "success");
        }
        else return cb()->redirectBack("Gagal Silakan Cek Kembali Jumlah Penarikan Yang Dimasikan !", "danger");
    }
}
