<?php

/** 
 * Default Controller
 * 
 * Get rates by state(s)
 * - domain.com/site/bystate?key=YIIDEV&state=CA
 * - domain.com/site/bystate?key=YIIDEV&state[]=AL&state[]=CA...
 *
 * Get rates by city/cities
 * - domain.com/site/bycity?key=YIIDEV&city=belk
 * - domain.com/site/bycity?key=YIIDEV&city[]=belk&city[]=arvin...
 *
 */
class SiteController extends Controller {
	/** 
	 * Get rates for a city
	 *
	 */
	public function actionByCity() {
		$cities = $this->request->getParam('city');

		// Make sure it's valid
		if(!$cities) {
			throw new CHttpException(401, "City Name is missing.");
		}

		// Get all rates
		$rates = BankRate::model()->getRatesByCity($cities);

		echo json_encode($rates);	    
		exit;
	}

	/** 
	 * Get rates for all cities by state
	 *
	 */
	public function actionByState() {
		$states = $this->request->getParam('state');

		// Make sure it's valid
		if(!$states) {
			throw new CHttpException(401, "State is missing.");
		}

		// Get all rates
		$rates = BankRate::model()->getRatesByState($states);

		echo json_encode($rates);	    
		exit;
	}

	/** 
	 * Default action is not supported
	 *
	 */
	public function actionIndex() {
		die('Index is not supported.');
	}
}