<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            //id người lập kế hoạch
            $table->integer('user_id');
            //tên kế hoạch
            $table->string('name');
            //đường dẫn ảnh cover
            $table->string('cover_image');
            //trạng thái của kế hoạch
            $table->string('state')->default('Lên kế hoạch');
            $table->timestamps();
            //thời gian bắt đầu và kết thúc
            $table->dateTime('start_time');
            $table->dateTime('end_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
