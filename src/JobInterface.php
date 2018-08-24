<?php

namespace Resque;

use \Exception;

/**
 * JobInterface
 *
 * Implement this to use a custom class hierarchy; that is, if you don't want
 * to subclass AbstractJob (which is probably much easier)
 */
interface JobInterface
{
	/**
	 * @param string $queue
	 * @return void
	 */
	public function setQueue($queue);

	/**
	 * @param array $payload
	 * @return void
	 */
	public function setPayload(array $payload);

	/**
	 * @return string
	 */

	public function getQueue();

	/**
	 * @return array
	 */
	public function getPayload();

	/**
	 * Actually performs the work of the job
	 *
	 * @return void
	 */
	public function perform();

}
