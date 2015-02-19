<?php namespace Monokakure\CSV;

use Illuminate\Support\ServiceProvider;

class CSVServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app['csvfacade'] = $this->app->share(function ($app)
		{
			return new \Monokakure\CSV\Factory;
		});
	}
}