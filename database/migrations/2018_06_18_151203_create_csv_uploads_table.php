<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCsvUploadsTable extends Migration
{

    public function up()
    {
        Schema::create('csv_uploads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('original_filename');
            $table->boolean('has_headers')->default(false);
            $table->longText('file_contents');
            $table->text('column_mapping')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('csv_uploads');
    }
}
