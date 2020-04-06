<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetailInformasiMasa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('info_masa', function (Blueprint $table) {
            $table->string('project')->nullable();
            $table->integer('fee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('info_masa', function (Blueprint $table) {
            $table->dropColumn('project');
            $table->dropColumn('fee');
        });
    }
}
