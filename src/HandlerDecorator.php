<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\sentry;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;
use Sentry\Monolog\Handler;
use Sentry\State\Scope;

use function is_array;

/**
 * Sentry handler decorator.
 */
class HandlerDecorator extends AbstractProcessingHandler
{
	/**
	 * Constructor.
	 *
	 * @param \Sentry\Monolog\Handler $handler Sentry handler
	 */
	public function __construct(
		protected Handler $handler
	) {
	}

	/**
	 * {@inheritDoc}
	 */
	protected function write(LogRecord $record): void
	{
		(function (LogRecord $record): void {
			/** @var \Sentry\Monolog\Handler $this */
			$this->hub->withScope(function (Scope $scope) use ($record): void {
				if ($this->hub->getClient()->getOptions()->shouldSendDefaultPii()) {
					if (isset($record->context['user_id'])) {
						$scope->setUser(['id' => $record->context['user_id']]);
					}
					elseif (isset($record->context['user'])) {
						$scope->setUser($record->context['user']);
					}
				}

				if (isset($record->context['extra']) && is_array($record->context['extra'])) {
					foreach ($record->context['extra'] as $key => $value) {
						$scope->setExtra((string) $key, $value);
					}
				}

				$context = $record->context;

				unset($context['user_id'], $context['user'], $context['extra']);

				$this->write(new LogRecord(
					$record->datetime,
					$record->channel,
					$record->level,
					$record->message,
					$context,
					$record->extra
				));
			});
		})->bindTo($this->handler, Handler::class)($record);
	}
}
