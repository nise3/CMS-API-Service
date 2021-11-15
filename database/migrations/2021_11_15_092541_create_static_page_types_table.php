<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticPageTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_page_types', function (Blueprint $table) {
            $table->id();
            $table->string('title',500);
            $table->string('title_en',250)->nullable();
            $table->string('page_code',300);
            $table->unsignedTinyInteger('type')->comment("1=>Page Block, 2=>Static Page");
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
        Schema::dropIfExists('static_page_types');
    }
}
