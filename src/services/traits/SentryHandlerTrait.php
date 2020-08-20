<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\sentry\services\traits;

use mako\sentry\HandlerDecorator;
use Sentry\ClientBuilder;
use Sentry\Monolog\Handler;
use Sentry\SentrySdk;

/**
 * Sentry handler trait.
 *
 * @property \mako\config\Config $config
 */
trait SentryHandlerTrait
{
	/*
	 * Returns a decorated sentry monolog handler.
	 *
	 * @return \mako\sentry\HandlerDecorator
	 */
	protected function getSentryHandler(): HandlerDecorator
	{
		$hub = SentrySdk::init();

		$hub->bindClient(ClientBuilder::create($this->config->get('application.logger.sentry', []))->getClient());

		return new HandlerDecorator(new Handler($hub));
	}
}
