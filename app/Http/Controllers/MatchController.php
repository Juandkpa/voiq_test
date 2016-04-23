<?php namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Toin0u\Geotools\Facade\Geotools;


class MatchController extends Controller {


	/**
	 * Action for trigger the match algorithm based on the zipcodes
	 * of the agents in view and the contacts saved previously in DB
	 */
	public function doMatch()
	{

		$agents = Request::all();

		$contacts = Contact::All();
		$agent1 = $agents['Agent_1'];
		$agent2 = $agents['Agent_2'];

		//use geocode for retrieve agents location (cordinates)
		$agent1_loc = $this->geocodeZip($agent1);
		$agent2_loc = $this->geocodeZip($agent2);

		$matching = $this->computeDistances($agent1_loc, $agent2_loc, $contacts);
		$matching = $matching;

		//render matching view for ajax petitions
		if( Request::ajax() )
		{
			$view =  View::make('matching',['matching'=>$matching]);
			return $view->render();
		}

	}

	/**
	 *  Geocode position based on provided zipcode
	 * @param $zipCode
	 * @return array  position [latitude, longitude]
	 */
	private function geocodeZip( $zipCode )
	{
		$param = array("address"=>$zipCode);
		$geo = \Geocoder::geocode('json', $param);
		$jsnGeo = json_decode($geo, true);

		$lat = floatval( $jsnGeo['results'][0]['geometry']['location']['lat'] );
		$lng = floatval( $jsnGeo['results'][0]['geometry']['location']['lng'] );
		return [$lat, $lng];
	}

	/**
	 *  Geocode position based on provided zipcode - only for testing
	 * @param $zipCode
	 * @return array  position [latitude, longitude]
	 */
	private function geocodeZip2( $zipCode )
	{
		$param = array("address"=>$zipCode);
		$geo = \Geocoder::geocode('json', $param);
		$jsnGeo = json_decode($geo, true);

		$lat = floatval( $jsnGeo['results'][0]['geometry']['location']['lat'] );
		$lng = floatval( $jsnGeo['results'][0]['geometry']['location']['lng'] );
		return [$lat, $lng];
	}
	/**
	 *  Calculate the distances between each contact in db and each agent. setting agent id (1, 2)
	 *  based on the proximity of each one
	 * @param $agent1_loc
	 * @param $agent2_loc
	 * @param $contacts
	 * @return mixed   object with the contact data and the matching assignment
	 */
	private function computeDistances($agent1_loc, $agent2_loc, $contacts)
	{
		//use geotools for get apropiate coordinate object
		$coordA1 = Geotools::coordinate($agent1_loc);
		$coordA2 = Geotools::coordinate($agent2_loc);

		foreach($contacts as $contact){

			//calculate distance to each agent using harversine distance
			$disA = Geotools::distance()->setFrom($coordA1)->setTo($contact->coordinate)->in('km')->haversine();
			$disB = Geotools::distance()->setFrom($coordA2)->setTo($contact->coordinate)->in('km')->haversine();
			if( $disA < $disB){
				$contact->agentid = 1;
			}else{
				$contact->agentid = 2;
			}
		}
		return $contacts;
	}

}
