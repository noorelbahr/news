<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('likable');
            $table->uuid('user_id')->index();
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('created_by');
            $table->uuid('updated_by');
            $table->uuid('deleted_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
