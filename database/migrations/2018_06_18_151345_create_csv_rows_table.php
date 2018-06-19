<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCsvRowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csv_rows', function (Blueprint $table) {
            $table->increments('id');
            $table->text('contents');
            $table->unsignedInteger('csv_upload_id')->index();;
            $table->foreign('csv_upload_id')
                ->references('id')
                ->on('csv_uploads')
                ->onDelete('cascade');
            $table->dateTime('imported_at')->nullable();
            $table->dateTime('warned_at')->nullable();
            $table->dateTime('failed_at')->nullable();
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
        Schema::dropIfExists('csv_rows');
    }
}
