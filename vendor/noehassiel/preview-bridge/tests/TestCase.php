<?php

namespace Noehassiel\PreviewBridge\Tests;

use Noehassiel\PreviewBridge\PreviewBridgeServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [PreviewBridgeServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('app.key', 'base64:'.base64_encode(str_repeat('a', 32)));
        $app['config']->set('preview-bridge.portal_origin', 'https://portal.test');
    }
}
