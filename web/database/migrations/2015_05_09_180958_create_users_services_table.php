<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_services', function($table)
		{
		    $table->increments('id');
		    $table->integer('user_id')->unsigned();
		    $table->integer('service_id')->unsigned();
		    $table->boolean('is_active');
		    $table->dateTime('active_until');
			$table->foreign('user_id')
				->references('id')
				->on('users');
			$table->foreign('service_id')
				->references('id')
				->on('services');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users_services');
	}

}
