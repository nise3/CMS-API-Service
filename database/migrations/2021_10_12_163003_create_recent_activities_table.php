<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecentActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recent_activities', function (Blueprint $table) {
            $table->increments("id");
            $table->string("title_en", 250);
            $table->string("title", 500);
            $table->string("alt_title_en", 250)->nullable();
            $table->string("alt_title", 500)->nullable();

            $table->unsignedTinyInteger('show_in_nise3')->default(0);
            $table->unsignedTinyInteger('show_in_youth')->default(0);
            $table->unsignedInteger('institute_id')->nullable();
            $table->unsignedInteger('organization_id')->nullable();
            $table->unsignedInteger('industry_association_id')->nullable();
            $table->tinyInteger('content_type')
                ->comment("1 => Image,2 => Video,3 => Youtube Source")->nullable();
            $table->string('content_path', 800)->nullable();
            $table->string("content_properties", 300)->nullable();

            $table->string('thumb_image_path', 600)->nullable();
            $table->string('grid_image_path', 600)->nullable();

            $table->text("description_en")->nullable();
            $table->text("description")->nullable();

            $table->dateTime('activity_date')->nullable();
            $table->dateTime('publish_date')->nullable();
            $table->dateTime('archive_date')->nullable();
            $table->tinyInteger('row_status')
                ->default(1)
                ->comment('ACTIVE_STATUS = 1; INACTIVE_STATUS = 0;');
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
        Schema::dropIfExists('recent_activities');
    }
}
