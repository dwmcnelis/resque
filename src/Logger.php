<?php
namespace Resque;

use Psr\Log\LoggerInterface;

class Logger implements LoggerInterface
{
  const EMERGENCY = 'emergency';
  const ALERT     = 'alert';
  const CRITICAL  = 'critical';
  const ERROR     = 'error';
  const WARNING   = 'warning';
  const NOTICE    = 'notice';
  const INFO      = 'info';
  const DEBUG     = 'debug';

  /**
   * Instantiate a new instance of a logger.
   */
  public function __construct()
  {
  }

  /**
   * System is unusable.
   *
   * @param string $message
   * @param array $context
   * @return void
   */
  public function emergency($message, array $context = array())
  {
    $this->log(self::EMERGENCY, $message, $context);
  }

  /**
   * Action must be taken immediately.
   *
   * Example: Entire website down, database unavailable, etc. This should
   * trigger the SMS alerts and wake you up.
   *
   * @param string $message
   * @param array $context
   * @return void
   */
  public function alert($message, array $context = array())
  {
    $this->log(self::ALERT, $message, $context);
  }

  /**
   * Critical conditions.
   *
   * Example: Application component unavailable, unexpected exception.
   *
   * @param string $message
   * @param array $context
   * @return void
   */
  public function critical($message, array $context = array())
  {
    $this->log(self::CRITICAL, $message, $context);
  }

  /**
   * Runtime errors that do not require immediate action but should typically
   * be logged and monitored.
   *
   * @param string $message
   * @param array $context
   * @return void
   */
  public function error($message, array $context = array())
  {
    $this->log(self::ERROR, $message, $context);
  }

  /**
   * Exceptional occurrences that are not errors.
   *
   * Example: Use of deprecated APIs, poor use of an API, undesirable things
   * that are not necessarily wrong.
   *
   * @param string $message
   * @param array $context
   * @return void
   */
  public function warning($message, array $context = array())
  {
    $this->log(self::WARNING, $message, $context);
  }

  /**
   * Normal but significant events.
   *
   * @param string $message
   * @param array $context
   * @return void
   */
  public function notice($message, array $context = array())
  {
    $this->log(self::NOTICE, $message, $context);
  }

  /**
   * Interesting events.
   *
   * Example: User logs in, SQL logs.
   *
   * @param string $message
   * @param array $context
   * @return void
   */
  public function info($message, array $context = array())
  {
    $this->log(self::INFO, $message, $context);
  }

  /**
   * Detailed debug information.
   *
   * @param string $message
   * @param array $context
   * @return void
   */
  public function debug($message, array $context = array())
  {
    $this->log(self::DEBUG, $message, $context);
  }

  /**
   * Logs with an arbitrary level.
   *
   * @param mixed $level
   * @param string $message
   * @param array $context
   * @return void
   */
  public function log($level, $message, array $context = array())
  {
    fwrite(STDOUT, '[' . strftime('%Y-%m-%d %T') . '] ' . strtoupper($level) . ': '  . $this->interpolate($message, $context) . "\n");
  }

  /**
   * Interpolates context values into the message placeholders.
   */
  private function interpolate($message, array $context = array())
  {
    if (false === strpos($message, '{')) {
      return $message;
    }
    $replace = array();
    foreach ($context as $key => $val) {
      if (null === $val || is_scalar($val) || (\is_object($val) && method_exists($val, '__toString'))) {
        $replace["{{$key}}"] = $val;
      } elseif ($val instanceof \DateTimeInterface) {
        $replace["{{$key}}"] = $val->format(\DateTime::RFC3339);
      } elseif (\is_object($val)) {
        $replace["{{$key}}"] = '[object '.\get_class($val).']';
      } else {
        $replace["{{$key}}"] = '['.\gettype($val).']';
      }
    }
    return strtr($message, $replace);
  }
}
?>
