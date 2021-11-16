<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleryImagesVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up()
    {
        Schema::create('gallery_images_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('gallery_album_id');

            $table->unsignedTinyInteger('featured')->default(0)
                ->comment('YES => 1, NO => 0');

            $table->dateTime('published_at')->nullable();
            $table->dateTime('archived_at')->nullable();

            $table->unsignedTinyInteger('content_type')
                ->default(1)
                ->comment('Image => 1, Video => 2');

            $table->unsignedTinyInteger('video_type')
                ->nullable()
                ->comment('youtube => 1, facebook => 2');

            $table->string('title', 600);
            $table->string('title_en', 250)->nullable();
            $table->text('description')->nullable();
            $table->text('description_en')->nullable();

            $table->string('image_path', 800)->nullable();
            $table->string('video_url', 800)->nullable();
            $table->string('video_id', 300)->nullable();
            $table->json('content_properties_json')->nullable();

            $table->string('content_grid_image_path')->nullable()->comment('Grid or List View Image');
            $table->string('content_thumb_image_path')->nullable();

            $table->string('alt_image_title', 600)->nullable();
            $table->string('alt_image_title_en', 250)->nullable();

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
        Schema::dropIfExists('gallery_images_videos');
    }
}
