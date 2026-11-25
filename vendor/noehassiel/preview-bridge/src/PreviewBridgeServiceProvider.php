<?php

namespace Noehassiel\PreviewBridge;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Noehassiel\PreviewBridge\Http\Middleware\InjectPreviewBridge;

class PreviewBridgeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/preview-bridge.php', 'preview-bridge');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/preview-bridge.php' => config_path('preview-bridge.php'),
        ], 'preview-bridge-config');

        // Registered always (cheap), but the middleware returns untouched responses while disabled
        $this->app->make(Kernel::class)->appendMiddlewareToGroup('web', InjectPreviewBridge::class);
    }
}
