<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\sentry\scrubbers;

use Sentry\Event;

/**
 * Scrubber interface.
 */
interface ScrubberInterface
{
	/**
	 * Removes basic auth details from URLs in the exception message.
	 */
	public function scrub(): ?Event;
}
