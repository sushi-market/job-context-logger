# Laravel Job Context Logger

A small Laravel package that adds information about the currently processed queue job to Laravel's logging context.

## Requirements

- PHP 8.2 or newer
- Laravel 11, 12, or 13

## Install

Run:

```sh
composer require sushi-market/job-context-logger
```

Laravel discovers the service provider automatically. No changes to the application's AppServiceProvider are needed.

## Configuration

Logging job details is enabled by default. To customize the setting, publish the package configuration:

```sh
php artisan vendor:publish --tag=job-context-logger-config
```

The published config/job-context-logger.php file contains:

```php
return [
    'enabled' => true,
    'context_key' => 'job',
];
```

Set enabled to false to disable the package. context_key controls the key under which job details are stored in Laravel's Context.

## Context fields

The package adds these fields while a queue job is being processed:

- name
- uuid
- connection
- queue
- attempts

Context is removed after successful processing. It is retained after failure so exception logging can include the job details.
