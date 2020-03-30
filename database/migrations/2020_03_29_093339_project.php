<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Project extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kategori_project_id');
            $table->timestamps();
			$table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('total')->nullable();
            $table->integer('taken')->nullable();
            $table->integer('fee')->nullable();
            $table->foreign('kategori_project_id')->references('id')->on('kategori_project')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project');
    }
}
