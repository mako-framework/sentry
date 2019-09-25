<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\sentry\services;

use mako\application\services\LoggerService as Service;
use mako\sentry\HandlerDecorator;
use Sentry\ClientBuilder;
use Sentry\Monolog\Handler;
use Sentry\SentrySdk;

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
		$hub = SentrySdk::init();

		$hub->bindClient(ClientBuilder::create($this->config->get('application.sentry', []))->getClient());

		return new HandlerDecorator(new Handler($hub));
	}
}
