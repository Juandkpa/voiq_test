<?php

use Illuminate\Database\Seeder;
use Ddeboer\DataImport\Reader\CsvReader;

class ContactSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//I did the assumption of all contact in a real application have to be
		//saved in DB in that way I use this seeder for achieve it
		$path = storage_path('imports/contacts.csv');
		$file = new \SplFileObject( $path );
		$reader = new CsvReader($file);

		// set row 0 as a header for get an associative array (name=>"Brian", zipcode=>"85751")
		//  from CSV file
		$reader->setHeaderRowNumber(0);
		$contacts = array();

		//geodecode all the contacts zipcodes stored in css file, and
		//save latitud and longitud in for each contact
		foreach($reader as $row)
		{
			$param = array("address"=>$row['zipcode']);
			$geo = \Geocoder::geocode('json', $param);
			$jsnGeo = json_decode( $geo, true);
			$row['lat'] = floatval( $jsnGeo['results'][0]['geometry']['location']['lat'] );
			$row['lng'] = floatval( $jsnGeo['results'][0]['geometry']['location']['lng'] );
			array_push($contacts, $row);
		}

		\DB::table('contacts')->insert($contacts);
	}

}
