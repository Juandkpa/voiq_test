<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContacts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/**
		 * Create a table for save the data of the contacts
		 */
		Schema::create('contacts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('zipcode');
			$table->double('lat');
			$table->double('lng');
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
		Schema::drop("contacts");
	}

}
