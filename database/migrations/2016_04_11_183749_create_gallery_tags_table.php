<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_gallery', function(Blueprint $table)
        {
            $table->unsignedInteger('album_id')
                ->nullable()
                ->index();
            $table->foreign('album_id')
                ->references('id')
                ->on('album')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('gallery_id')->nullable()->index();
            $table->foreign('gallery_id')->references('id')->on('gallery')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('gallery_games');
        Schema::dropIfExists('gallery_roster');
        Schema::dropIfExists('gallery_sport');
    }
}
