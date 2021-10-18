<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedTinyInteger('show_in')->comment('1=>Nise3, 2=>TSP, 3=>Industry, 4=>Industry Association');
            $table->unsignedInteger('institute_id')->nullable()->comment('For Particular TSP Website');
            $table->unsignedInteger('industry_association_id')->nullable()->comment('For Particular Industry Association Website');
            $table->unsignedInteger('organization_id')->nullable()->comment('For Particular Industry Website');

            $table->string('question', 2000);
            $table->string('question_en', 1000);
            $table->text('answer');
            $table->text('answer_en');

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
        Schema::dropIfExists('faqs');
    }
}
