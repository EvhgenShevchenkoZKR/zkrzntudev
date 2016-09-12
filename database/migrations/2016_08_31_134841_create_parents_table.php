<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parents', function (Blueprint $table) {
          $table->increments('id');
          $table->string('title');
          $table->string('title_children'); // title for children section
          $table->string('title_tags');// title for tags section
          $table->string('slug');
          $table->string('meta_title');
          $table->string('meta_keywords');
          $table->text('meta_description');
          $table->text('description');
          $table->boolean('published');
          $table->integer('user_id')->unsigned();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          $table->timestamps();
        });

        Schema::create('parent_tags', function (Blueprint $table){
          $table->increments('id');
          $table->integer('parent_page_id')->unsigned();
          $table->foreign('parent_page_id')->references('id')->on('parents')->onDelete('cascade');
          $table->integer('tag_id')->unsigned();
          $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
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
        Schema::drop('parent_tags');
        Schema::drop('parents');
    }
}
