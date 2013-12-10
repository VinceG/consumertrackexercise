<?php

/** 
 * Rate Controller
 * 
 *
 */
class RateController extends Controller {
	/**
	 * Add a new rate to the bank rate table
	 * 
	 */
	public function actionAdd() {
		$city = trim($this->request->getParam('city'));
		$state = trim(strtoupper($this->request->getParam('state')));
		$rate = intval($this->request->getParam('rate'));

		// Validate all fields were set
		if(!$rate) {
			throw new CHttpException(500, "Sorry, You must provide the rate amount.");
		}

		if(!$city) {
			throw new CHttpException(500, "Sorry, You must provide the city name.");
		}

		if(!$state || !State::model()->find('state_code=:state', array(':state' => $state))) {
			throw new CHttpException(500, "Sorry, You must provide a valid state code.");
		}

		// Add new
		$cityRecord = new City;
		$cityRecord->city = $city;
		$cityRecord->state_code = $state;
		if(!$cityRecord->save()) {
			throw new CHttpException(500, "Could not save the new city.");
		}

		// Add bank rate
		$bankRate = new BankRate;
		$bankRate->city_id = $cityRecord->id;
		$bankRate->rate = $rate;
		if(!$bankRate->save()) {
			throw new CHttpException(500, "Could not save the new bank rate.");
		}

		// Load the newly created record
		echo json_encode(array('status' => 'OK', 'record' => $bankRate->attributes));
		exit;
	}

	/**
	 * Update bank rate based on city name
	 *
	 */
	public function actionUpdate() {
		$city = trim($this->request->getParam('city'));
		$rate = intval($this->request->getParam('rate'));

		// Validate all fields were set
		if(!$rate) {
			throw new CHttpException(500, "Sorry, You must provide the rate amount.");
		}

		if(!$city) {
			throw new CHttpException(500, "Sorry, You must provide the city name.");
		}

		$row = BankRate::model()->with(array('city'))->find('city.city=:name', array(':name' => $city));

		if(!$row) {
			throw new CHttpException(500, "Sorry, We could not find a record with that name.");
		}

		// Update rate
		$row->rate = $rate;
		$row->update();

		// Load the newly created record
		echo json_encode(array('status' => 'OK', 'record' => $row->attributes));
		exit;
	}

	/**
	 * Delete a city bank rate by city name
	 *
	 */
	public function actionDelete() {
		$city = trim($this->request->getParam('city'));

		if(!$city) {
			throw new CHttpException(500, "Sorry, You must provide the city name.");
		}

		$row = BankRate::model()->with(array('city'))->find('city.city=:name', array(':name' => $city));

		if(!$row) {
			throw new CHttpException(500, "Sorry, We could not find a record with that name.");
		}

		// Delete
		$row->delete();

		echo json_encode(array('status' => 'OK'));
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