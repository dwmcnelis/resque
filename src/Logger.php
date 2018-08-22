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
  const NONE     = 'none';

  protected $min_level = self::DEBUG;
  protected $levels = [
      self::DEBUG,
      self::INFO,
      self::NOTICE,
      self::WARNING,
      self::NONE,
      self::ERROR,
      self::CRITICAL,
      self::ALERT,
      self::EMERGENCY
  ];

  protected $ansi = false;

  /**
   * Instantiate a new instance of a logger.
   */
  public function __construct()
  {
  }

  /**
   * Set minimum output level.
   *
   * @param boolean $level
   * @return void
   */
  public function min_level($level)
  {
    $this->min_level = $level;
  }

 /**
   * Set quiet output level (error and above).
   *
   * @param boolean $level
   * @return void
   */
  public function quiet()
  {
    $this->min_level = self::NONE;
  }

 /**
   * Set normal output level (error and above).
   *
   * @param boolean $level
   * @return void
   */
  public function normal()
  {
    $this->min_level = self::INFO;
  }

 /**
   * Set normal output level (error and above).
   *
   * @param boolean $level
   * @return void
   */
  public function verbose()
  {
    $this->min_level = self::NOTICE;
  }

 /**
   * Set normal output level (error and above).
   *
   * @param boolean $level
   * @return void
   */
  public function very_verbose()
  {
    $this->min_level = self::NOTICE;
  }

 /**
   * Set normal output level (error and above).
   *
   * @param boolean $level
   * @return void
   */
  public function extremely_verbose()
  {
    $this->min_level = self::DEBUG;
  }

  /**
   * @param string $level
   * @return boolean
   */
  protected function suppressed_level($level)
  {
  	return !(\array_search($level, $this->levels) >= \array_search($this->min_level, $this->levels));
  }

  /**
   * Enable/Disable ANSI (colorized) output.
   *
   * @param boolean $enabled
   * @return void
   */
  public function ansi($enabled)
  {
    $this->ansi = $enabled;
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
	  if ($this->suppressed_level(self::EMERGENCY)) {
	    return;
	  }
  	if ($this->ansi) {
  		fwrite(STDOUT, $this->colorStart('red', true));
  	}
    $this->log(self::EMERGENCY, $message, $context);
  	if ($this->ansi) {
  		fwrite(STDOUT, $this->colorReset());
  	}
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
	  if ($this->suppressed_level(self::ALERT)) {
	    return;
	  }
  	if ($this->ansi) {
  		fwrite(STDOUT, $this->colorStart('magenta', true));
  	}
    $this->log(self::ALERT, $message, $context);
  	if ($this->ansi) {
  		fwrite(STDOUT, $this->colorReset());
  	}
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
	  if ($this->suppressed_level(self::CRITICAL)) {
	    return;
	  }
  	if ($this->ansi) {
  		fwrite(STDOUT, $this->colorStart('red', true));
  	}
    $this->log(self::CRITICAL, $message, $context);
  	if ($this->ansi) {
  		fwrite(STDOUT, $this->colorReset());
  	}
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
	  if ($this->suppressed_level(self::ERROR)) {
	    return;
	  }
  	if ($this->ansi) {
  		fwrite(STDOUT, $this->colorStart('red'));
  	}
    $this->log(self::ERROR, $message, $context);
  	if ($this->ansi) {
  		fwrite(STDOUT, $this->colorReset());
  	}
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
	  if ($this->suppressed_level(self::WARNING)) {
	    return;
	  }
  	if ($this->ansi) {
  		fwrite(STDOUT, $this->colorStart('yellow'));
  	}
    $this->log(self::WARNING, $message, $context);
  	if ($this->ansi) {
  		fwrite(STDOUT, $this->colorReset());
  	}
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
	  if ($this->suppressed_level(self::NOTICE)) {
	    return;
	  }
  	if ($this->ansi) {
  		fwrite(STDOUT, $this->colorStart('white', true));
  	}
    $this->log(self::NOTICE, $message, $context);
  	if ($this->ansi) {
  		fwrite(STDOUT, $this->colorReset());
  	}
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
	  if ($this->suppressed_level(self::INFO)) {
	    return;
	  }
  	if ($this->ansi) {
  		fwrite(STDOUT, $this->colorStart('white'));
  	}
    $this->log(self::INFO, $message, $context);
  	if ($this->ansi) {
  		fwrite(STDOUT, $this->colorReset());
  	}
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
	  if ($this->suppressed_level(self::DEBUG)) {
	    return;
	  }
  	if ($this->ansi) {
  		fwrite(STDOUT, $this->colorStart('magenta'));
  	}
    $this->log(self::DEBUG, $message, $context);
  	if ($this->ansi) {
  		fwrite(STDOUT, $this->colorReset());
  	}
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
	  if ($this->suppressed_level($level)) {
	    return;
	  }
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

  private function colorStart($color, $bright = false)
  {
		$code = 0;

		switch ($color) {
		case "black":
			$code = 0;
			break;
		case "red":
			$code = 1;
			break;
		case "green":
			$code = 2;
			break;
		case "yellow":
			$code = 3;
			break;
		case "blue":
			$code = 4;
			break;
		case "magenta":
			$code = 5;
			break;
		case "cyan":
			$code = 6;
			break;
		case "white":
			$code = 7;
			break;
		default:
			$code = 7;
		}

		$code += 30;
		if ($bright) {
			return "\033[" . "{$code}" . ";1m";
		} else {
			return "\033[" . "{$code}" . "m";
		}

	}

  private function colorReset()
  {
		return "\033[0m";
	}
}
?>
