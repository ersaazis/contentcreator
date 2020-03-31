<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getIndex(){
        $data = [];
        $data['page_title'] = "Dashboard";
        $data['user'] = DB::table('users')->find(cb()->session()->id());
        if(cb()->session()->roleId() == 2) {
           $data['project_active']=DB::table('job')->where('users_id',cb()->session()->id())->where(function($q){
                $q->where('status','Belum Dikerjakan')->orWhere('status','Ditolak');
           })->count();
           $data['notif']=DB::table('notification')->where('users_id',cb()->session()->id())->limit(5)->orderBy('id','desc')->get();
           return view("dashboard", $data);
        }
        else {
           return view("dashboard_admin", $data);
        }
    }
}
