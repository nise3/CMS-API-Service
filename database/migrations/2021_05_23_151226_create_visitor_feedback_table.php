<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitor_feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('institute_id')->nullable();
            $table->unsignedInteger('organization_id')->nullable();
            $table->unsignedInteger('organization_association_id')->nullable();

            $table->string('name', 400);
            $table->string('name_en', 200);

            $table->string('mobile', 191)->nullable();
            $table->string('email', 191)->nullable();

            $table->string('address', 1200)->nullable();
            $table->string('address_en', 600)->nullable();

            $table->text('comment')->nullable();
            $table->text('comment_en')->nullable();

            $table->unsignedTinyInteger('form_type')->comment('FORM_TYPE_FEEDBACK = 1, FORM_TYPE_CONTACT = 2');

            $table->dateTime('read_at')->nullable();

            $table->unsignedTinyInteger('row_status')
                ->default(1)
                ->comment('ACTIVE_STATUS = 1, INACTIVE_STATUS = 0');

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
        Schema::dropIfExists('visitor_feedbacks');
    }
}
