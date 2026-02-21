<?php

/**
 * @copyright Frederic G. Østby
 * @license   http://www.makoframework.com/license
 */

namespace mako\sentry\services;

use mako\application\services\LoggerService as Service;
use mako\sentry\services\traits\SentryLoggerServiceTrait;

/**
 * Logger service.
 */
class LoggerService extends Service
{
	use SentryLoggerServiceTrait;
}
