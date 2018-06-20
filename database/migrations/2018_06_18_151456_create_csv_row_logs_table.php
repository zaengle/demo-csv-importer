<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCsvRowLogsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csv_row_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('csv_row_id')->index();;
            $table->foreign('csv_row_id')
                ->references('id')
                ->on('csv_rows')
                ->onDelete('cascade');
            $table->string('code')->nullable();
            $table->string('pipe')->nullable();
            $table->text('message')->nullable();
            $table->string('level')->nullable();
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
        Schema::dropIfExists('csv_row_logs');
    }
}
