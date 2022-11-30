<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\sentry\tests\unit;

use Exception;
use mako\sentry\scrubbers\BasicAuth;
use Monolog\Test\TestCase;
use Sentry\Event;
use Sentry\EventHint;

/**
 * @group unit
 */
class BasicAuthTest extends TestCase
{
	/**
	 * Returns the exception message.
	 *
	 * @return string
	 */
	protected function getMessage(): string
	{
		return <<<'MESSAGE'
		error https://foobar:barfoo@host.com error
		MESSAGE;
	}

	/**
	 * Returns the expected exception message.
	 *
	 * @return string
	 */
	protected function getExcpectedMessage(): string
	{
		return <<<'MESSAGE'
		error https://[redacted]@host.com error
		MESSAGE;
	}

	/**
	 *
	 */
	public function testScrub(): void
	{
		$event = Event::createEvent();

		$hint  = EventHint::fromArray(['exception' => new Exception($this->getMessage())]);

		$scrubber = new BasicAuth($event, $hint);

		$this->assertSame($this->getExcpectedMessage(), $scrubber->scrub()->getMessage());

		$this->assertSame($this->getExcpectedMessage(), $hint->exception->getMessage());
	}

	/**
	 *
	 */
	public function testScrubUsingInvoke(): void
	{
		$event = Event::createEvent();

		$hint  = EventHint::fromArray(['exception' => new Exception($this->getMessage())]);

		$scrubber = new BasicAuth($event, $hint);

		$this->assertSame($this->getExcpectedMessage(), $scrubber()->getMessage());

		$this->assertSame($this->getExcpectedMessage(), $hint->exception->getMessage());
	}
}
