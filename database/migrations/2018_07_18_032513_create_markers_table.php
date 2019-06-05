<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('markers', function (Blueprint $table) {
            $table->increments('id');
            //kinh độ
            $table->double('lat', 18, 15);
            //vĩ độ
            $table->double('lng', 18, 15);
            //nhãn
            $table->string('label')->nullable();
            $table->timestamps();
            //id của kế hoạch
            $table->integer('plan_id')->nullable();
            //số thứ tự
            $table->integer('index_in_plan')->nullable();
            //placeId cho google maps
            $table->string('place_id')->nullable();
            $table->text('place_detail')->nullable();
            //link liên kết đên google maps
            $table->boolean('has_link')->default(0);

            //thời gian tới và rời địa điểm
            $table->dateTime('arriver_time')->nullable();
            $table->dateTime('leave_time')->nullable();
            //hoạt động tại địa điểm
            $table->string('activity')->nullable();
            //hằng số travelMode của google
            $table->string('travel_mode')->default('DRIVING');
            //text phương tiện
            $table->string('vehicle')->nullable();
            //đường đi có đi qua những điểm xác định không
            $table->boolean('has_waypoints')->default(0);
            //chỉ só của đường đi thay thế
            $table->integer('route_index')->default(0);
            //đường đi
            $table->text('waypoints')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('markers');
    }
}
