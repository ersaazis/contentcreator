<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Project';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $jobs=DB::table('job')->where(function($query){
            $query->where('status','Ditolak')->orWhere('status','Belum Dikerjakan');
        })->where('expire','<',date('Y-m-d'));
        foreach($jobs->get() as $item){
            $project=DB::table('project')->find($item->project_id);
            DB::table('project')->where('id',$item->project_id)->update([
                'taken'=>$project->taken-1
            ]);

            $user=DB::table('users')->find($item->users_id);
            DB::table('users')->where('id',$item->users_id)->update([
                'project_fail'=>$user->project_fail+1
            ]);

            DB::table('notification')->insert([
                'users_id'=>$item->users_id,
                'title'=>'Project '.$item->title.' Talah Gagal',
                'description'=>"Melebihi batas waktu"
            ]);
        }
        $jobs->delete();
    }
}
