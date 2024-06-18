<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalistKzPeopleTable extends Migration
{
    public function up()
    {
        Schema::create('journalist_kz_people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('journalist_id');
            $table->unsignedBigInteger('kz_person_id');
            $table->timestamps();

            $table->foreign('journalist_id')->references('id')->on('journalists')->onDelete('cascade');
            $table->foreign('kz_person_id')->references('id')->on('kz_people')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('journalist_kz_people');
    }
}
