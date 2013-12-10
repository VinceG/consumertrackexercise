<?php

namespace yii\composer;

use Composer\Script\Event;

defined('YII_DEBUG') or define('YII_DEBUG', true);

// fcgi doesn't have STDIN defined by default
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));

define('ROOT_PATH', dirname(dirname(dirname(__FILE__))));
defined('YII_PATH') or define('YII_PATH', ROOT_PATH . '/protected/vendor/yiisoft/yii/framework');
defined('CONSOLE_CONFIG') or define('CONSOLE_CONFIG', ROOT_PATH . '/protected/config/console.php');

/**
 * InstallHandler provides composer hooks
 */
class InstallHandler
{
  /**
   * Pre-install event - display simple message
   *
   * @param \Composer\Script\Event $event
   */
  public static function preInstall(Event $event)
  {
    $composer = $event->getComposer();
    echo "Installer for application\n\n";
    echo " * download packages specified in composer.json * trigger composer callbacks\n\n";
    if (self::confirm("Start Installation?"))
    {
        self::runHook('pre-install');
    }
    else
    {
        exit("Installation aborted.\n");
    }
  }

  /**
   * Post-install event - executes database migrations
   *
   * @param \Composer\Script\Event $event
   */
  public static function postInstall(Event $event)
  {
    self::runHook('post-install');
    echo "\n\nInstallation completed.\n\n";
  }

  /**
   * Pre-update event - displays welcome message
   *
   * @param \Composer\Script\Event $event
   */
  public static function preUpdate(Event $event)
  {
    echo "Updating your application to the lastest available packages...\n";
    self::runHook('pre-update');
  }

  /**
   * Post-udpate event - executes database migrations
   *
   * @param \Composer\Script\Event $event
   */
  public static function postUpdate(Event $event)
  {
    self::runHook('post-update');
    echo "\n\nUpdate completed.\n\n";
  }

  /**
   * Post-package install event - executes ./yiic <vendor/<packageName>-install
   *
   * @param \Composer\Script\Event $event
   */
  public static function postPackageInstall(Event $event)
  {
    $installedPackage = $event->getOperation()->getPackage();
    $hookName = $installedPackage->getPrettyName() . '-install';
    self::runHook($hookName);
  }

  /**
   * Post-package update event - xecutes ./yiic <vendor/<packageName>-update
   *
   * @param \Composer\Script\Event $event
   */
  public static function postPackageUpdate(Event $event)
  {
    $installedPackage = $event->getOperation()->getTargetPackage();
    $commandName = $installedPackage->getPrettyName() . '-update';
    self::runHook($commandName);
  }

  /**
   * Asks user to confirm by typing y or n.
   *
   * @param string $message to echo out before waiting for user input
   * @return bool if user confirmed
   */
  public static function confirm($message)
  {
    echo $message . ' [yes|no] ';
    return !strncasecmp(trim(fgets(STDIN)), 'y', 1);
  }

  /**
   * Runs Yii command, if available (defined in config/console.php)
   */
  private static function runHook($name){
    $app = self::getYiiApplication();

    if ($app === null)
    {
      return;
    }
    // If hook is defined in application cofig then run it
    if (isset($app->params['composer.callbacks'][$name]))
    {
      echo "Running hook {$name}\n\n";
      $args = $app->params['composer.callbacks'][$name];
      $app->commandRunner->addCommands(\Yii::getPathOfAlias('system.cli.commands'));
      $app->commandRunner->run($args);
    }
  }

  /**
   * Creates console application, if Yii is available
   */
  private static function getYiiApplication()
  {
    if (!is_file(YII_PATH . '/yii.php'))
    {
      return null;
    }

    require_once(YII_PATH . '/yii.php');

    if (\Yii::app() === null)
    {
      if (is_file(CONSOLE_CONFIG))
      {
        $config = require_once(CONSOLE_CONFIG);
        $app = \Yii::createConsoleApplication($config);
      }
      else
      {
        throw new \Exception("File from CONSOLE_CONFIG not found");
      }
    }
    else
    {
      $app = \Yii::app();
    }
    return $app;
  }
}