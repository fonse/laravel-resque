## Laravel Resque

This package allows you to connect to Resque when using `Queue`. 

## Requirements

- PHP 5.3+
- Illuminate\Config 4.0+
- Illuminate\Queue 4.0+
- Resque 1.2+
- ResqueScheduler 1.1+

## Installation

First you need to add the following to your project's `composer.json`:

    "require": {
    	"awellis13/laravel-resque": "1.x"
    }

Now you need to run the following to install the package:

	composer update

Next you need to add the following service provider to your `app/config/app.php`:

    'Awellis13\Resque\ServiceProviders\ResqueServiceProvider'

Now you need to add the following to your `/app/config/queue.php` "connections" section:

    "resque" => array(
    	"driver" => "resque"
    )

If you wish to use this driver as your default Queue driver you will need to set the following as your "default" drive in `app/config/queue.php`:

    "default" => "resque",


## Usage

If you choose to not use this driver as your default Queue driver you can call a Queue method on demand by doing:

    Queue::connection('resque')->push('JobName', array('name' => 'Andrew'));

### Enqueing a Job

	Queue::push('JobName', array('name' => 'Andrew'));

### Tracking a Job

	$token = Queue::push('JobName', array('name' => 'Andrew'), true);
	$status = Queue::getStatus($token);

### Enqueing a Future Job

	$when = time() + 3600; // 1 hour from now
	Queue::later($when, 'JobName', array('name' => 'Andrew'));

## Further Documentation

- [PHP-Resque](https://github.com/chrisboulton/php-resque)
- [PHP-Resque-Scheduler](https://github.com/chrisboulton/php-resque-scheduler)

## License

Laravel Resque is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).