<?php namespace Awellis13\Resque\Connectors;

use Config;
use Resque;
use ResqueScheduler;
use Awellis\Resque\ResqueQueue;
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
		Resque::setBackend(Config::get('database.redis.default.host').':'.Config::get('database.redis.default.port'));
		return new ResqueQueue;
	}

} // End ResqueConnector
