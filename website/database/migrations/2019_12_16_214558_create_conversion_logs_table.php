<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversion_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('amount');
            $table->string('from_currency');
            $table->string('to_currency');
            $table->string('converted');
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
        Schema::dropIfExists('conversion_logs');
    }
}
