<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleryAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_albums', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('parent_gallery_album_id')->nullable();
            $table->unsignedTinyInteger('featured')->default(0)
                ->comment('YES => 1, NO => 0');

            $table->unsignedTinyInteger('show_in')
                ->comment('1=>Nise3, 2=> Youth, 3=>TSP, 4=>Industry, 5=>Industry Association');

            $table->unsignedTinyInteger('album_type')
                ->comment('1 => Image, 2 => Video, 3 => Mixed');

            $table->dateTime('published_at')->nullable();
            $table->dateTime('archived_at')->nullable();

            $table->unsignedInteger('institute_id')->nullable();
            $table->unsignedInteger('organization_id')->nullable();
            $table->unsignedInteger('industry_association_id')->nullable();

            $table->unsignedInteger('course_id ')->nullable();
            $table->unsignedInteger('program_id')->nullable();

            $table->string('title', 600);
            $table->string('title_en', 200)->nullable();

            $table->string('main_image_path', 600)->nullable();
            $table->string('thumb_image_path', 600)->nullable();
            $table->string('grid_image_path', 600)->nullable()->comment('List or Grid Image');

            $table->string("image_alt_title", 500)->nullable();
            $table->string("image_alt_title_en", 250)->nullable();

            $table->unsignedTinyInteger('row_status')
                ->default(1)
                ->comment('ACTIVE_STATUS = 1, INACTIVE_STATUS = 0');

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
        Schema::dropIfExists('gallery_albums');
    }
}
