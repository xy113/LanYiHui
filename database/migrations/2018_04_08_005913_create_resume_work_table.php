<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResumeWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_work', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('resume_id')->default(0);
            $table->string('company')->default('');
            $table->string('job')->default('');
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
        Schema::dropIfExists('resume_work');
    }
}
