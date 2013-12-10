<?php
/**
 * Composer install handler
 * This runs when composer runs install/update
 *
 */
class InstallHandlerCommand extends CConsoleCommand 
{
	/**
	 * Composer pre install hook
	 *
	 */
	public function actionPreInstall() {
		// validate Requirements
		$this->validateRequired();

		// Run migrations
      	$this->runMigrations();
	}
	/**
	 * Composer post install hook
	 *
	 */
	public function actionPostInstall() {
		// Validate Required
		$this->validateRequired();
		
		echo "Setting Permissions\n";
		$this->setPermissions();

		// Run migrations
      	$this->runMigrations();
	}
	/**
	 * Composer pre update hook
	 *
	 */
	public function actionPreUpdate() {

	}
	/**
	 * Composer post update hook
	 *
	 */
	public function actionPostUpdate() {
		echo "Setting Permissions\n";
		$this->setPermissions();
	}

	protected function validateRequired() {
		$file = Yii::getPathOfAlias('application.config') . '/params-local.php';
		if(!file_exists($file)) {
			throw new Exception("Could not locate $file please create that file based of params-local.dist.php");
		}
	}

	// run migrations
	protected function runMigrations() {
		Yii::app()->commandRunner->addCommands(\Yii::getPathOfAlias('system.cli.commands'));
      	Yii::app()->commandRunner->run(array('yiic', 'migrate'));
	}

	// Set permissions
	protected function setPermissions() {
		$dirs = array(
			Yii::getPathOfAlias('application.runtime'),
		);

		foreach($dirs as $dir) {
			echo "Changing Permission " . $dir . "\n";
			if(!is_dir($dir)) {
				if(!mkdir($dir)) {
					throw new Exception("Could not create required permissions for " . $dir . ". Please create it manually.");
				}
			}
			if(!is_writable($dir) || !chmod($dir, 0777)) {
				throw new Exception("Could not set required permissions for " . $dir . ". Please set the permissions manually to 0777");
			}
		}
	}
}