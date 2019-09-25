<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\sentry\services;

use mako\application\services\LoggerService as Service;
use mako\sentry\HandlerDecorator;
use Monolog\Formatter\LineFormatter;
use Sentry\ClientBuilder;
use Sentry\Monolog\Handler;
use Sentry\SentrySdk;
use Sentry\State\Hub;

/**
 * Logger service.
 */
class LoggerService extends Service
{
	/*
	 * Returns a decorated sentry monolog handler.
	 *
	 * @return \mako\sentry\HandlerDecorator
	 */
	protected function getSentryHandler(): HandlerDecorator
	{
		$client = ClientBuilder::create(['dsn' => $this->config->get('application.sentry_dsn')])->getClient();

		SentrySdk::init()->bindClient($client);

		$handler = new HandlerDecorator(new Handler(new Hub($client)));

		$handler->setFormatter(new LineFormatter("%message% %context% %extra%\n"));

		return $handler;
	}
}
