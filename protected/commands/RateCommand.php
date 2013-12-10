<?php
/**
 * Rate Command
 */
class RateCommand extends CConsoleCommand
{
	    public function getHelp()
		{
			return <<<EOD
	USAGE
   		- yiic.php rate bystate [options]
				1. --state=state code
	DESCRIPTION
EOD;
		}
		
		/**
		 * Command index action
		 */
		public function actionIndex() {
			die("\n\n--------------------------------------------------------\nPlease use --help to understand how to use this command.\n--------------------------------------------------------\n\n");
		}

}