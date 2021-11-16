<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticPageBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_page_blocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('static_page_type_id');
            $table->unsignedTinyInteger('show_in')
                ->comment('1=>Nise3, 2=> Youth, 3=>TSP, 4=>Industry, 5=>Industry Association');

            $table->unsignedInteger('institute_id')->nullable();
            $table->unsignedInteger('organization_id')->nullable();
            $table->unsignedInteger('industry_association_id')->nullable();

            $table->string('title', 600);
            $table->string('title_en', 200)->nullable();

            $table->text('content')->nullable();
            $table->text('content_en')->nullable();

            $table->unsignedTinyInteger('attachment_type')
                ->comment("1 => Image, 2 => Facebook source, 3 => Youtube Source")->nullable();

            $table->string("template_code", 20)->comment("BT_LR,BT_RL,BT_CB")->nullable();
            $table->unsignedTinyInteger('is_button_available')->default(0);
            $table->string('button_text', 20)->nullable();
            $table->string('link', 300)->nullable();
            $table->unsignedTinyInteger('is_attachment_available')->default(0);
            $table->string('image_path', 800)->nullable();
            $table->string('embedded_url', 800)->nullable();
            $table->string('embedded_id', 300)->nullable();
            $table->string('alt_image_title_en')->nullable();
            $table->string('alt_image_title')->nullable();

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->tinyInteger('row_status')
                ->default(1)
                ->comment('ACTIVE_STATUS => 1, INACTIVE_STATUS => 0');

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
        Schema::dropIfExists('page_blocks');
    }
}
