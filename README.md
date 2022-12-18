# Mako Sentry

[![Build Status](https://github.com/mako-framework/sentry/workflows/Tests/badge.svg)](https://github.com/mako-framework/sentry/actions?query=workflow%3ATests)
[![Static analysis](https://github.com/mako-framework/sentry/actions/workflows/static-analysis.yml/badge.svg)](https://github.com/mako-framework/sentry/actions/workflows/static-analysis.yml)

A [Sentry](https://sentry.io/welcome/) integration for the Mako Framework.

## Requirements

Mako 8.0 or greater.

## Installation

Install the package using the following composer command:

```
composer require mako/sentry
```

Next you'll have to add a `logger.sentry` config key to your `application.php` config file.

```
'logger' =>
[
	...
	'sentry' =>
	[
		'dsn' => 'https://<key>@sentry.io/<project>',
	],
	...
],
```

Then you'll have to replace the default `LoggerService` with the included `LoggerService` in the `application.php` config file.

```
'services' =>
[
	'core' =>
	[
		...
		mako\sentry\services\LoggerService::class,
		...
	],
],
```

And finally you'll have to enable logging to sentry by setting the `logger.handler` key in the `application.php` config file to the following value:

```
'logger' =>
[
	...
	'handler' => ['Sentry', 'Stream'],
	...
],
```

> Note that you can disable the default file logging by setting the value to `['Sentry']`.
