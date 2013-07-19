<?php namespace Awellis13\Resque;

use Resque;
use ResqueScheduler;
use Resque_Event;
use Illuminate\Queue\Queue;

/**
 * Class ResqueQueue
 *
 * @package Queue
 */
class ResqueQueue extends Queue {

	/**
	 * Calls methods on the Resque and ResqueScheduler classes.
	 *
	 * @param string $method
	 * @param array  $parameters
	 * @return mixed
	 */
	public function __callStatic($method, $parameters)
	{
		if (method_exists('Resque', $method))
		{
			return call_user_func_array(array('Resque', $method), $parameters);
		}
		else if (method_exists('ResqueScheduler', $method))
		{
			return call_user_func_array(array('RescueScheduler', $method), $parameters);
		}

		return call_user_func_array(array('Queue', $method,) $parameters);
	}

	/**
	 * Push a new job onto the queue.
	 *
	 * @param  string  $job
	 * @param  array   $data
	 * @param  string  $queue
	 * @param  bool    $track
	 * @return string
	 */
	public function push($job, $data = [], $queue = null, $track = false)
	{
		$queue = (is_null($queue) ? $job : $queue);
		return Resque::enqueue($queue, $job, $data, $track);
	}

	/**
	 * Push a new job onto the queue after a delay.
	 *
	 * @param  int     $delay
	 * @param  string  $job
	 * @param  mixed   $data
	 * @param  string  $queue
	 * @return void
	 */
	public function later($delay, $job, $data = [], $queue = null)
	{
		$queue = (is_null($queue) ? $job : $queue);

		if (is_int($delay))
		{
			ResqueScheduler::enqueueIn($delay, $queue, $job, $data);
		}
		else
		{
			ResqueScheduler::enqueueAt($delay, $queue, $job, $data);
		}
	}

	/**
	 * Pop the next job off of the queue.
	 *
	 * @param  string  $queue
	 * @return \Illuminate\Queue\Jobs\Job|null
	 */
	public function pop($queue = null)
	{
		return Resque::pop($queue);
	}

	/**
	 * Register a callback for an event.
	 *
	 * @param string $event
	 * @param object $function
	 */
	public function listen($event, $function)
	{
		Resque_Event::listen($event, $function);
	}

	/**
	 * Returns the job's status.
	 *
	 * @return int
	 */
	public function jobStatus($token)
	{
		$status = new Resque_Job_status($token);
		return $status->get();
	}

	/**
	 * Get the queue or return the default.
	 *
	 * @param  string|null  $queue
	 * @return string
	 */
	protected function getQueue($queue)
	{
		return $queue ?: $this->default;
	}

} // End ResqueQueue
