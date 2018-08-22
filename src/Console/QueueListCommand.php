<?php

namespace Resque\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QueueListCommand extends Command
{
	/**
	 * @return void
	 */
	protected function configure()
	{
		parent::configure();

		$this
			->setName('queue:list')
			->setDescription('Outputs information about queues');
	}

	/**
	 * @param InputInterface  $input
	 * @param OutputInterface $output
	 * @return int
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$resque = $this->getResque($output);
		$queues = $resque->queues();

		foreach ($queues as $queue) {
			$size = $resque->size($queue);
			$output->writeln($queue . " " . $size);
		}

		if (!count($queues)) {
			$output->writeln('No queues');
			return 1; // If no queues, return error exit code
		}

		return 0;
	}
}
