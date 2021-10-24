<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecentActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('recent_activities', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedTinyInteger('show_in')
                ->comment('1=>Nise3, 2=> Youth, 3=>TSP, 4=>Industry, 5=>Industry Association');

            $table->date('activity_date')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->dateTime('archived_at')->nullable();

            $table->unsignedInteger('institute_id')->nullable();
            $table->unsignedInteger('organization_id')->nullable();
            $table->unsignedInteger('industry_association_id')->nullable();

            $table->string("title_en", 300);
            $table->string("title", 1000);

            $table->unsignedTinyInteger('content_type')
                ->comment("1 => Image, 2 => Video, 3 => Youtube Source")->nullable();

            $table->string('content_path', 800)->nullable();
            $table->string("content_properties", 300)->nullable();

            $table->string('collage_image_path', 600)->nullable()->comment('Main Image');
            $table->unsignedTinyInteger('collage_position')->nullable()
                ->comment('Available Values: [1.1, 1.2.1, 1.2.2.1, 1.2.2.2]');
            $table->string('thumb_image_path', 600)->nullable();
            $table->string('grid_image_path', 600)->nullable()->comment('List or Grid Image');

            $table->string("image_alt_title_en", 250)->nullable();
            $table->string("image_alt_title", 500)->nullable();

            $table->text("description_en")->nullable();
            $table->text("description")->nullable();

            $table->unsignedTinyInteger('row_status')
                ->default(1)
                ->comment('ACTIVE_STATUS = 1, INACTIVE_STATUS = 0');

            $table->unsignedInteger('published_by')->nullable();
            $table->unsignedInteger('archived_by')->nullable();
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
        Schema::dropIfExists('recent_activities');
    }
}
