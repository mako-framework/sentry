<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\sentry;

use Monolog\Handler\AbstractProcessingHandler;
use Sentry\Monolog\Handler;
use Sentry\State\Scope;

/**
 * Sentry handler decorator.
 *
 * @author Frederic G. Østby
 */
class HandlerDecorator extends AbstractProcessingHandler
{
	/**
	 * Undocumented variable.
	 *
	 * @var \Sentry\Monolog\Handler
	 */
	protected $handler;

	/**
	 * Constructor.
	 *
	 * @param \Sentry\Monolog\Handler $handler Sentry handler
	 */
	public function __construct(Handler $handler)
	{
		$this->handler = $handler;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function write(array $record): void
	{
		(function($record): void
		{
			if(isset($record['context']['user_id']))
			{
				$this->hub->configureScope(function(Scope $scope) use ($record): void
				{
					$scope->setUser(['id' => $record['context']['user_id']]);
				});

				unset($record['context']['user_id']);
			}
			elseif(isset($record['context']['user']))
			{
				$this->hub->configureScope(function(Scope $scope) use ($record): void
				{
					$scope->setUser($record['context']['user']);
				});

				unset($record['context']['user']);
			}

			$this->write($record);
		})->bindTo($this->handler, Handler::class)($record);
	}
}
