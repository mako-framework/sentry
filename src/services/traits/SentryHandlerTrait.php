<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\sentry\services\traits;

use mako\sentry\HandlerDecorator;
use Sentry\ClientBuilder;
use Sentry\Integration\EnvironmentIntegration;
use Sentry\Integration\FrameContextifierIntegration;
use Sentry\Integration\RequestIntegration;
use Sentry\Integration\TransactionIntegration;
use Sentry\Monolog\Handler;
use Sentry\SentrySdk;

/**
 * Sentry handler trait.
 *
 * @property \mako\config\Config $config
 */
trait SentryHandlerTrait
{
	/**
	 * Get Sentry options.
	 */
	protected function getSentryOptions(): array
	{
		$config = $this->config->get('application.logger.sentry', []);

		return $config +
		[
			'default_integrations' => false,
			'integrations'         =>
			[
				new RequestIntegration,
				new TransactionIntegration,
				new FrameContextifierIntegration,
				new EnvironmentIntegration,
			],
		];
	}

	/*
	 * Returns a decorated sentry monolog handler.
	 */
	protected function getSentryHandler(): HandlerDecorator
	{
		$hub = SentrySdk::init();

		$hub->bindClient(ClientBuilder::create($this->getSentryOptions())->getClient());

		return new HandlerDecorator(new Handler($hub));
	}
}
