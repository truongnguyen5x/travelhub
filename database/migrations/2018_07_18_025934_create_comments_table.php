<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            //id người dùng
            $table->integer('user_id');
            //id kế hoạch
            $table->integer('plan_id');
            //nội dung của comment
            $table->text('content');
            //id của comment cấp 1 (nếu có)
            $table->integer('parent_comment_id')->nullable();
            //id của marker chứa vị trí hiện tại
            $table->integer('location_id')->nullable();
            //ngày tạo
            $table->dateTime('date_created');
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
        Schema::dropIfExists('comments');
    }
}
