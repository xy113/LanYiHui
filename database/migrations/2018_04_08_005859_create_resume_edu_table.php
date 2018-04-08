<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResumeEduTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resume_edu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('resume_id')->default(0);
            $table->string('school')->default('');
            $table->string('major')->default('未知');
            $table->enum('degree',['0','1','2','3','4','5','6'])->default('0');   //0：其他 1：小学 2：初中 3：高中 4：学士 5：硕士 6：博士
            $table->date('start_time')->nullable();
            $table->date('end_time')->nullable();
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
        Schema::dropIfExists('resume_edu');
    }
}
