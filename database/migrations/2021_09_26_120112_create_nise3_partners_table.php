<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNise3PartnersTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     **/
    public function up()
    {
        Schema::create('nise3_partners', function (Blueprint $table) {

            $table->increments("id");

            $table->string('title_en',250);
            $table->string('title',500);

            $table->string('main_image_path', 600)->nullable();
            $table->string('thumb_image_path', 600)->nullable();
            $table->string('grid_image_path', 600)->nullable()->comment('List or Grid Image');

            $table->string('domain', 150)->nullable();

            $table->string("image_alt_title_en",250)->nullable();
            $table->string("image_alt_title",500)->nullable();

            $table->unsignedTinyInteger('row_status')
                ->default(1)
                ->comment('ACTIVE_STATUS => 1, INACTIVE_STATUS => 0');

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nise3_partners');
    }
}
