<?php namespace Awellis13\Resque\Connectors;

use Config;
use Resque;
use ResqueScheduler;
use Awellis13\Resque\ResqueQueue;
use Illuminate\Queue\Connectors\ConnectorInterface;

/**
 * Class ResqueConnector
 *
 * @package Queue\Connectors
 */
class ResqueConnector implements ConnectorInterface {

	/**
	 * Establish a queue connection.
	 *
	 * @param  array  $config
	 * @return \Illuminate\Queue\QueueInterface
	 */
	public function connect(array $config)
	{
		if (!isset($config['host']))
		{
			$config = Config::get('database.redis.default');
		}

		if (!isset($config['port']))
		{
			$config['port'] = 6379;
		}

		Resque::setBackend($config['host'].':'.$config['port']);
		return new ResqueQueue;
	}

} // End ResqueConnector
