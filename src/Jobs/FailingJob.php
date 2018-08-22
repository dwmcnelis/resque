<?php
namespace Resque\Jobs;

use Resque\AbstractJob;

class FailingJob extends AbstractJob
{

	public function perform()
	{
		throw new \Exception('This job just failed');
	}

}
