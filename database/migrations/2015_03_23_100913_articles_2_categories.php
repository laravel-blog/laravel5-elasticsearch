<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Articles2Categories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('articles_2_categories', function(Blueprint $table)
        {
            $table->unsignedInteger('article_id');
            $table->unsignedInteger('category_id');
            $table->primary(['article_id', 'category_id']);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('articles_2_categories');
	}

}
