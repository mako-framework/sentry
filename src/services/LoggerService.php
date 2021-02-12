<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\sentry\services;

use mako\application\services\LoggerService as Service;
use mako\sentry\HandlerDecorator;
use Sentry\ClientBuilder;
use Sentry\Integration\FrameContextifierIntegration;
use Sentry\Integration\RequestIntegration;
use Sentry\Integration\TransactionIntegration;
use Sentry\Monolog\Handler;
use Sentry\SentrySdk;

/**
 * Logger service.
 */
class LoggerService extends Service
{
	/**
	 * Get Sentry options.
	 *
	 * @return array
	 */
	protected function getSentryOptions(): array
	{
		$config = $this->config->get('application.sentry', []);

		return $config +
		[
			'default_integrations' => false,
			'integrations'         =>
			[
				new RequestIntegration,
				new TransactionIntegration,
				new FrameContextifierIntegration,
			],
		];
	}

	/*
	 * Returns a decorated sentry monolog handler.
	 *
	 * @return \mako\sentry\HandlerDecorator
	 */
	protected function getSentryHandler(): HandlerDecorator
	{
		$hub = SentrySdk::init();

		$hub->bindClient(ClientBuilder::create($this->getSentryOptions())->getClient());

		return new HandlerDecorator(new Handler($hub));
	}
}
