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
            $table->unsignedTinyInteger('type')
                ->comment('1 => Notice,2 => News');

            $table->unsignedTinyInteger('show_in')
                ->comment('1=>Nise3, 2=> Youth, 3=>TSP, 4=>Industry, 5=>Industry Association');

            $table->dateTime('published_at')->nullable();
            $table->dateTime('archived_at')->nullable();

            $table->string('title_en', 250)->nullable();
            $table->string('title', 500);

            $table->unsignedInteger('institute_id')->nullable();
            $table->unsignedInteger('organization_id')->nullable();
            $table->unsignedInteger('industry_association_id')->nullable();

            $table->text('details')->nullable();
            $table->text('details_en')->nullable();

            $table->string('main_image_path')->nullable();
            $table->string('grid_image_path')->nullable();
            $table->string('thumb_image_path')->nullable();

            $table->string("image_alt_title_en")->nullable();
            $table->string("image_alt_title")->nullable();

            $table->string('file_path')->nullable();
            $table->string("file_alt_title_en")->nullable();
            $table->string("file_alt_title")->nullable();

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
        Schema::dropIfExists('notice_or_news');
    }
}
