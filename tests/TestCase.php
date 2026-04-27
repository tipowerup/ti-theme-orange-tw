<?php

declare(strict_types=1);

namespace TiPowerUp\OrangeTw\Tests;

use Illuminate\Foundation\Application;
use TiPowerUp\OrangeTw\ServiceProvider;
use Tipowerup\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getExtensionBasePath(): string
    {
        return dirname(__DIR__);
    }

    /**
     * @return array<int, class-string>
     */
    protected function getExtensionProviders(): array
    {
        return [ServiceProvider::class];
    }

    /**
     * @param  Application  $app
     */
    protected function defineEnvironment($app): void
    {
        parent::defineEnvironment($app);

        // Required for view rendering and any service that touches Crypt.
        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
    }
}
