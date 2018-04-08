<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResumeProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_project', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('resume_id')->default(0);
            $table->string('project')->default('');
            $table->string('url')->default('');
            $table->date('start_time')->nullable();
            $table->date('end_time')->nullable();
            $table->text('experience')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resume_project');
    }
}
