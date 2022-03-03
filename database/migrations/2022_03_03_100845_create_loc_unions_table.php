<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocUnionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loc_unions', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedMediumInteger('loc_division_id');
            $table->unsignedMediumInteger('loc_district_id');
            $table->unsignedMediumInteger('loc_upazila_id');
            $table->string('title_en');
            $table->string('title', 500);
            $table->char('bbs_code', 6)->nullable();
            $table->unsignedTinyInteger('row_status')
                ->default(1)
                ->comment('ACTIVE_STATUS = 1, INACTIVE_STATUS = 0');
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
        Schema::dropIfExists('loc_unions');
    }
}
