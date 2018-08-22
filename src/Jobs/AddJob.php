<?php
namespace Resque\Jobs;

use Resque\AbstractJob;

class AddJob extends AbstractJob
{

  public function beforePerform()
  {
    fwrite(STDOUT, "Resque\Jobs\AddJob->beforePerform" . "\n");
  }

  public function perform()
  {
    // work work work
    $args = array_key_exists('args', $this->payload) ? $this->payload['args'] : [];
    fwrite(STDOUT, "Resque\Jobs\AddJob->perform" . " args: " . json_encode($args) . " result: " . array_sum($args) . "\n");
  }

  public function afterPerform()
  {
    fwrite(STDOUT, "Resque\Jobs\AddJob->afterPerform" . "\n");
  }


}
?>
