<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     **/
    public function up()
    {
        Schema::create('cms_languages', function (Blueprint $table) {

            $table->increments('id');
            $table->string('table_name', 250);
            $table->unsignedInteger('key_id');
            $table->char('lang_code');
            $table->string('column_name', 250);
            $table->text('column_value');
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
        Schema::dropIfExists('cms_languages');
    }
}
