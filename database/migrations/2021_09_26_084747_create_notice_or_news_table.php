<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticeOrNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notice_or_news', function (Blueprint $table) {

            $table->increments("id");
            $table->tinyInteger('type')->comment('1=>Notice,2=>News');

            $table->unsignedTinyInteger('show_in')
                ->comment('1=>Nise3, 2=>TSP, 3=>Industry, 4=>Industry Association');

            $table->string('title_en', 250);
            $table->string('title', 500);

            $table->unsignedInteger('institute_id')->nullable();
            $table->unsignedInteger('organization_id')->nullable();
            $table->unsignedInteger('organization_association_id')->nullable();

            $table->text('details_en')->nullable();
            $table->text('details')->nullable();

            $table->string('main_image_path')->nullable();
            $table->string('grid_image_path')->nullable();
            $table->string('thumb_image_path')->nullable();

            $table->string('file_path')->nullable();
            $table->string("image_alt_title_en")->nullable();
            $table->string("image_alt_title")->nullable();

            $table->string("file_alt_title_en")->nullable();
            $table->string("file_alt_title")->nullable();

            $table->tinyInteger('row_status')->default(1);
            $table->dateTime('publish_date')->nullable();
            $table->dateTime('archive_date')->nullable();

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
        Schema::dropIfExists('notice_or_news');
    }
}
