<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorFeedbacksSuggestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** Table to store Visitors Contact Us and Suggestion  Form Data */

        Schema::create('visitor_feedbacks_suggestions', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedTinyInteger('form_type')
                ->comment('suggestion = 1, contactus = 2');

            $table->unsignedInteger('institute_id')->nullable();
            $table->unsignedInteger('organization_id')->nullable();
            $table->unsignedInteger('industry_association_id')->nullable();

            $table->string('name', 600);
            $table->string('name_en', 200)->nullable();

            $table->string('mobile', 15)->nullable();
            $table->string('email', 254)->nullable();

            $table->string('address', 1200)->nullable();
            $table->string('address_en', 600)->nullable();

            $table->text('comment')->nullable();
            $table->text('comment_en')->nullable();

            $table->dateTime('read_at')->nullable();
            $table->dateTime('archived_at')->nullable();

            $table->unsignedInteger('archived_by')->nullable();

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
        Schema::dropIfExists('visitor_feedbacks_suggestions');
    }
}
