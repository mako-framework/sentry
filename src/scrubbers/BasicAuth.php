<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\sentry\scrubbers;

use ReflectionObject;
use Sentry\Event;
use Sentry\EventHint;
use Throwable;

use function preg_match;
use function preg_replace;

/**
 * Basic auth scrubber.
 */
class BasicAuth
{
	/**
	 * Regex matching basic auth in URLs.
	 */
	protected const REGEX = '/(https?:\/\/)([^\s]+:[^\s]+)(@)/iu';

	/**
	 * Event.
	 *
	 * @var \Sentry\Event
	 */
	protected $event;

	/**
	 * Event hint.
	 *
	 * @var \Sentry\EventHint|null
	 */
	protected $hint;

	/**
	 * Constructor.
	 *
	 * @param \Sentry\Event          $event Event
	 * @param \Sentry\EventHint|null $hint  Event hint
	 */
	public function __construct(Event $event, ?EventHint $hint)
	{
		$this->event = $event;

		$this->hint = $hint;
	}

	/**
	 * Removes basic auth details from URLs in the exception message.
	 *
	 * @param \Throwable $exception Exception
	 */
	protected function scrubExceptionMessage(Throwable $exception): void
	{
		$message = $exception->getMessage();

		if(preg_match(static::REGEX, $message) === 1)
		{
			$exceptionReflection = new ReflectionObject($exception);

			$messageReflection = $exceptionReflection->getProperty('message');

			$messageReflection->setAccessible(true);

			$message = preg_replace(static::REGEX, '$1[redacted]$3', $message);

			$messageReflection->setValue($exception, $message);
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function scrub(): Event
	{
		if($this->event !== null && $this->hint !== null && $this->hint->exception instanceof Throwable)
		{
			$this->scrubExceptionMessage($this->hint->exception);

			$this->event->setMessage($this->hint->exception->getMessage());
		}

		return $this->event;
	}

	/**
	 * Removes basic auth details from URLs in the exception message.
	 *
	 * @return \Sentry\Event
	 */
	public function __invoke(): Event
	{
		return $this->scrub();
	}
}
