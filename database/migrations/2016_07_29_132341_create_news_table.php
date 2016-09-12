<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * ID
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->longText('body');
            $table->text('slug');
            $table->boolean('published');
            $table->boolean('important');//show in front slider or not
            $table->integer('author_id')->unsigned();//relation to users table
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('cover_image');
            $table->boolean('cover_show');//show cover in side slider or not
            $table->string('cover_title');
            $table->string('cover_alt');
            $table->string('meta_title');
            $table->string('meta_keywords');
            $table->text('meta_description');
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
        Schema::drop('news');
    }
}
