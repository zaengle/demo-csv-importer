<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllergyParticipantPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allergy_participant', function (Blueprint $table) {
            $table->unsignedInteger('allergy_id');
            $table->foreign('allergy_id')
            	->references('id')
            	->on('allergies');
            $table->unsignedInteger('participant_id');
            $table->foreign('participant_id')
            	->references('id')
            	->on('participants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allergy_participant');
    }
}
