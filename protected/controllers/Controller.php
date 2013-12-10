<?php


class Controller extends CController {
	/**
	 * Yii Request shortcut
	 * @var object
	 */
	protected $request;
	/**
	 * API Key provided with the request
	 * @var string
	 */
	protected $key;

	/**
	 * Limit the number of request we can do per @interval
	 * @var int
	 */
	protected $limit = 100;

	/**
	 * The interval the limit above applies to (in minutes)
	 * @var int
	 */
	protected $interval = 1;

	/**
	 * The time to deny access to the service once usage limits were met
	 * @var int
	 */
	protected $blockTimeout = 2;

	/** 
	 * Init method
	 */
	public function init() {
		// Request shortcut
		$this->request = Yii::app()->request;
		
		// Validate key
		$this->validateAPIKey();

		// Validate usage
		$this->validateUsage();
	}

	/** 
	 * Validate the usage limits with the requests
	 * number of request should not be higher than @limit within @interval
	 * @throws CHttpException
	 */
	protected function validateUsage() {
		// Init
		$cache = Yii::app()->cache;
		$key = sprintf('%s_%s_usage', $this->getKey(), $_SERVER['REMOTE_ADDR']);
		$newTime = time();
		$c = 1;
		$initTime = time();
		$status = 'OK';

		$info = $cache->get($key);

		if($info) {
			$s = $info[3];
		  	$c = $info[0]+1;
		  	$initTime = $info[1];

			if($s == 'TOO_MANY_REQUESTS') {
				$d = time()-$info[1]; // time since block
			    if( (($this->blockTimeout*60) - $d) > 0) {  // still blocked
			    	throw new CHttpException(500, sprintf("Sorry, You have exceeded the maximum allowed number of request (%s) per %s minute(s). You'll be able to process requests within %s minute(s)", $this->limit, $this->interval, (((($this->blockTimeout*60)-$d)/60) ) ));
			    } else {  // block is over
			      $status = 'OK';
			      $initTime = time();
			      $c = 0;
				}
			}

		  	if($c > $this->limit) {
		  		$timeElapsed = $newTime - $initTime;
			    if($timeElapsed < ($this->interval*60)) {  
			      $status = 'TOO_MANY_REQUESTS'; 
			    }
			    
			    $c = 0;
			    $initTime = time();
			}
		}

		$cache->set($key, array($c, $initTime, $newTime, $status) );
	}

	/** 
	 * This used to validate the api key passed
	 * this being a sample will just make sure that they
	 * pass in the following: DEV
	 */
	protected function validateAPIKey() {
		// Save
		$this->setKey($this->request->getParam('key'));
		
		if(!$this->getKey() || $this->getKey() != 'DEV') {
			throw new CHttpException(403, "Sorry, There was no API key provided or the API key is invalid.");
		}

		return true;
	}

	/**
	 * Set API key
	 * @return string
	 */
	protected function setKey($key) {
		return $this->key = $key;
	}

	/**
	 * get API key
	 * @return string
	 */
	protected function getKey() {
		return $this->key;
	}
}