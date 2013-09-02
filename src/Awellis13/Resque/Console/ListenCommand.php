<?php namespace Awellis13\Resque\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Config;
use Resque;
use Resque_Worker;

class ListenCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'resque:listen';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Run a resque worker';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		// Read input
		$logLevel = $this->input->getOption('verbose') ? Resque_Worker::LOG_NORMAL : 0;
		$queue    = $this->input->getOption('queue');
		$interval = $this->input->getOption('interval');

		// Connect to redis
		Resque::setBackend(Config::get('database.redis.default.host').':'.Config::get('database.redis.default.port'));

		// Launch worker
		$queues           = explode(',', $queue);
		$worker           = new Resque_Worker($queues);
		$worker->logLevel = $logLevel;

		fwrite(STDOUT, '*** Starting worker ' . $worker . "\n");
		$worker->work($interval);
	}
	
	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('queue', null, InputOption::VALUE_OPTIONAL, 'The queue to listen on', 'default'),
			array('interval', null, InputOption::VALUE_OPTIONAL, 'Amount of time to delay failed jobs', 5),
		);
	}

}
