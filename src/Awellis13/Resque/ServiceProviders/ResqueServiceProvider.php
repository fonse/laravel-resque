<?php namespace Awellis13\Resque\ServiceProviders;

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
		$manager->addConnector('resque', function()
		{
			return new ResqueConnector;
		});
	}

} // End ResqueServiceProvider
