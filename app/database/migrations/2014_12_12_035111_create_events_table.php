<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gatherings', function($table) 
		{
	        $table->increments('id');
	        $table->timestamps();
	        
	        $table->string('type');
	        $table->string('location');
	        $table->string('date');
	        $table->string('description');
	        $table->integer('attending');
    	});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gatherings');
	}

}
