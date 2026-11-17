<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

/**
 * Lets the external admin system toggle maintenance mode over HTTP,
 * since the host does not allow SSH access to run artisan directly.
 */
class MaintenanceController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $token = (string) config('services.ops.token');

        abort_if($token === '' || ! hash_equals($token, (string) $request->bearerToken()), 403);

        $validated = $request->validate([
            'action' => ['required', 'in:up,down'],
            'secret' => ['nullable', 'string', 'min:16', 'max:128', 'regex:/^[A-Za-z0-9-]+$/'],
            'refresh' => ['nullable', 'integer', 'min:5', 'max:3600'],
        ]);

        if ($validated['action'] === 'up') {
            Artisan::call('up');

            return response()->json(['status' => 'up']);
        }

        $options = ['--refresh' => $validated['refresh'] ?? 15];

        if ($secret = $validated['secret'] ?? config('services.ops.bypass_secret')) {
            $options['--secret'] = $secret;
        }

        Artisan::call('down', $options);

        return response()->json(['status' => 'down']);
    }
}
