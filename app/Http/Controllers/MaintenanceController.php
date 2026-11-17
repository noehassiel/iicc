<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

/**
 * Lets the external admin system run a small set of artisan commands over
 * HTTP, since the host allows neither SSH nor scheduled tasks.
 */
class MaintenanceController extends Controller
{
    /**
     * Artisan command and fixed options for each allowed action.
     *
     * @var array<string, array{0: string, 1: array<string, mixed>}>
     */
    private const COMMANDS = [
        'migrate' => ['migrate', ['--force' => true]],
        'seed' => ['db:seed', ['--force' => true]],
        'link' => ['storage:link', []],
        'optimize' => ['optimize', []],
        'optimize-clear' => ['optimize:clear', []],
    ];

    public function __invoke(Request $request): JsonResponse
    {
        $token = (string) config('services.ops.token');

        abort_if($token === '' || ! hash_equals($token, (string) $request->bearerToken()), 403);

        $validated = $request->validate([
            'action' => ['required', 'in:up,down,'.implode(',', array_keys(self::COMMANDS))],
            'secret' => ['nullable', 'string', 'min:16', 'max:128', 'regex:/^[A-Za-z0-9-]+$/'],
            'refresh' => ['nullable', 'integer', 'min:5', 'max:3600'],
        ]);

        $action = $validated['action'];

        if ($action === 'up') {
            Artisan::call('up');

            return response()->json(['status' => 'up']);
        }

        if ($action === 'down') {
            $options = ['--refresh' => $validated['refresh'] ?? 15];

            if ($secret = $validated['secret'] ?? config('services.ops.bypass_secret')) {
                $options['--secret'] = $secret;
            }

            Artisan::call('down', $options);

            return response()->json(['status' => 'down']);
        }

        [$command, $options] = self::COMMANDS[$action];

        set_time_limit(300);

        $exitCode = Artisan::call($command, $options);

        return response()->json([
            'action' => $action,
            'exit_code' => $exitCode,
            'output' => trim(Artisan::output()),
        ], $exitCode === 0 ? 200 : 500);
    }
}
