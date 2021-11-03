<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_pages_and_block', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedTinyInteger('content_type')
                ->comment("1 => Page Block, 2 => Static Page");

            $table->unsignedTinyInteger('show_in')
                ->comment('1=>Nise3, 2=> Youth, 3=>TSP, 4=>Industry, 5=>Industry Association');

            $table->string('content_slug_or_id', 300);

            $table->unsignedInteger('institute_id')->nullable();
            $table->unsignedInteger('organization_id')->nullable();
            $table->unsignedInteger('organization_association_id')->nullable();

            $table->string('title', 600);
            $table->string('title_en', 200)->nullable();

            $table->string('sub_title', 600)->nullable();
            $table->string('sub_title_en', 200)->nullable();

            $table->text('contents')->nullable();
            $table->text('contents_en')->nullable();

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
        Schema::dropIfExists('static_pages');
    }
}
