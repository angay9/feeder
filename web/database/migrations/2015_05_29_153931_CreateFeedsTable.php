<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feeds', function($table)
		{
		    $table->increments('id');
			$table->string('title');
			$table->string('link');
			$table->string('pub_date');
			$table->string('description');
			$table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('feeds');
	}

}
