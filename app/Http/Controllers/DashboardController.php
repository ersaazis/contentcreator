<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getIndex(){
        $data = [];
        $data['page_title'] = "Dashboard";
        $data['users'] = DB::table('users')->orderBy('project_sucess','DESC')->limit(5)->get();
        $data['user'] = DB::table('users')->find(cb()->session()->id());
        $data['info'] = DB::table('info_masa')->limit(5)->get();
        if(cb()->session()->roleId() == 2) {
           $data['project_active']=DB::table('job')->where('users_id',cb()->session()->id())->where(function($q){
                $q->where('status','Belum Dikerjakan')->orWhere('status','Ditolak');
           })->count();
           $data['notif']=DB::table('notification')->where('users_id',cb()->session()->id())->limit(5)->orderBy('id','desc')->get();
           return view("dashboard", $data);
        }
        else {
           $data['project'] = DB::table('job')->count();
           $data['project_success'] = DB::table('job')->where('status','Selesai')->count();
           $data['all_payment'] = DB::table('project')->select(DB::raw('sum(fee*total) as fee'))->first()->fee;
           $data['all_payment_project'] = DB::table('job')->select(DB::raw('sum(fee) as fee'))->first()->fee;
           $data['req_payment'] = DB::table('payment')->where('status','Dalam Proses')->count();
           $data['potential_payment'] = DB::table('users')->where('fee','>=',500000)->select(DB::raw('sum(fee) as fee'))->first()->fee;
           $data['job'] = DB::table('job')->where('status','Dalam Proses')->count();
           $data['jum_users'] = DB::table('users')->count();
        //    dd($data);
           return view("dashboard_admin", $data);
        }
    }
}
