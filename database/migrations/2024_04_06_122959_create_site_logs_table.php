<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('site_id');
            $table->boolean('status')->default(null);
            $table->integer('status_code')->default(null);
            $table->timestamps();
            $table->foreign('site_id')->on('sites')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_logs');
    }
};
