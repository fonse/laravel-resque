<?php namespace Awellis13\Resque\ServiceProviders;

use Config;
use Awellis13\Resque\Connectors\ResqueConnector;
use Illuminate\Queue\QueueServiceProvider;

/**
 * Class ResqueServiceProvider
 *
 * @package Queue
 */
class ResqueServiceProvider extends QueueServiceProvider {

	/**
	 * {@inheritdoc}
	 */
	public function registerConnectors($manager)
	{
		parent::registerConnectors($manager);
		$this->registerResqueConnector($manager);
	}

	/**
	 * Register the Resque queue connector.
	 *
	 * @param  \Illuminate\Queue\QueueManager  $manager
	 * @return void
	 */
	protected function registerResqueConnector($manager)
	{
		$connections = Config::get('queue.connections', []);
		foreach ($connections as $connection)
		{
			if ($connection['driver'] !== 'resque')
			{
				$manager->addConnector($connection['driver'], function()
				{
					return new ResqueConnector();
				});
			}
		}

		$manager->addConnector('resque', function()
		{
			$config = Config::get('database.redis.default');
			Config::set('queue.connections.resque', array_merge($config, ['driver' => 'resque']));
			return new ResqueConnector;
		});
	}

} // End ResqueServiceProvider
