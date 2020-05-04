<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
			$table->string('name');
            $table->timestamps();

            $table->unique(['name']);
        });
		Schema::create('courses_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id');
            $table->foreignId('tag_id');
            $table->timestamps();

            $table->unique(['course_id', 'tag_id']);
                
            $table->foreign('tag_id')
            ->references('id')
            ->on('tags')
            ->onDelete('cascade');
			
			
            $table->foreign('course_id')
            ->references('id')
            ->on('courses')
            ->onDelete('cascade');

        });
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
		Schema::dropIfExists('articles_tags');
    }
}
