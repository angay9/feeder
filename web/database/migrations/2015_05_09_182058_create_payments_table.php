<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function($table)
		{
		    $table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('service_id')->unsigned();
			$table->dateTime('created_at');
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('service_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('payments');
	}

}
