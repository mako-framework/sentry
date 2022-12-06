<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\sentry;

use Monolog\Handler\AbstractProcessingHandler;
use Sentry\Monolog\Handler;
use Sentry\State\Scope;

use function is_array;

/**
 * Sentry handler decorator.
 */
class HandlerDecorator extends AbstractProcessingHandler
{
	/**
	 * Sentry handler.
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
	 * {@inheritDoc}
	 */
	protected function write(array $record): void
	{
		(function ($record): void
		{
			$this->hub->withScope(function (Scope $scope) use ($record): void
			{
				if($this->hub->getClient()->getOptions()->shouldSendDefaultPii())
				{
					if(isset($record['context']['user_id']))
					{
						$scope->setUser(['id' => $record['context']['user_id']]);
					}
					elseif(isset($record['context']['user']))
					{
						$scope->setUser($record['context']['user']);
					}
				}

				if(isset($record['context']['extra']) && is_array($record['context']['extra']))
				{
					foreach($record['context']['extra'] as $key => $value)
					{
						$scope->setExtra((string) $key, $value);
					}
				}

				unset($record['context']['user_id'], $record['context']['user'], $record['context']['extra']);

				$this->write($record);
			});
		})->bindTo($this->handler, Handler::class)($record);
	}
}
