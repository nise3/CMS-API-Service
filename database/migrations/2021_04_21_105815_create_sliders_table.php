<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('institute_id')->nullable();
            $table->unsignedInteger('industry_association_id')->nullable();
            $table->unsignedInteger('organization_id')->nullable();
            $table->unsignedTinyInteger('show_in')
                ->comment('1=>Nise3, 2=> Youth, 3=>TSP, 4=>Industry, 5=>Industry Association');
            $table->string('title_en', 191)->nullable();
            $table->string('title', 500);
            $table->string('sub_title_en', 191);
            $table->string('sub_title', 500);
            $table->unsignedTinyInteger('is_button_available')->default(0);
            $table->string('button_text', 20)->nullable();
            $table->string('link', 191)->nullable();
            $table->text('slider_images')->comment("[image_link1,image_link2.........]");
            $table->string('alt_title_en')->nullable();
            $table->string('alt_title')->nullable();
            $table->string("banner_template_code",20)->comment("BT_LR,BT_RL,BT_CB")->nullable();
            $table->unsignedTinyInteger('row_status')
                ->default(1)
                ->comment('ACTIVE_STATUS = 1, INACTIVE_STATUS = 0');
            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();
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
        Schema::dropIfExists('sliders');
    }
}
