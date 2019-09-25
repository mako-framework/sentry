# Mako Sentry

A [Sentry](https://sentry.io/welcome/) integration for the Mako Framework.

## Requirements

Mako 6.0 or greater.

## Installation

Install the package using the following composer command:

```
composer require mako/sentry
```

Next you'll have to add a `sentry` config key to your `application.php` config file.

```
'sentry' =>
[
	'dsn' => 'https://<key>@sentry.io/<project>',
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

And finally you'll have to enable logging to sentry by setting the `log_handler` key in the `application.php` config file to the following value:

```
'log_handler' => ['stream', 'sentry'],
```

> Note that you can disable the default file logging by setting the value to `sentry` or `['sentry']`.