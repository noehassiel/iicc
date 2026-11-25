<?php

namespace Noehassiel\PreviewBridge\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Lets the portal frame this site and adds the script that reports the current page.
 * Does nothing unless the bridge is enabled.
 */
class InjectPreviewBridge
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! config('preview-bridge.enabled')) {
            return $response;
        }

        $origin = rtrim((string) config('preview-bridge.portal_origin'), '/');

        $this->allowFraming($response, $origin);

        if ($this->isHtmlPage($request, $response)) {
            $this->injectScript($response, $origin);
        }

        return $response;
    }

    /** Only the portal may frame the preview; X-Frame-Options would block it outright. */
    private function allowFraming(Response $response, string $origin): void
    {
        $response->headers->remove('X-Frame-Options');

        $policy = $response->headers->get('Content-Security-Policy');
        $frameAncestors = "frame-ancestors 'self' {$origin}";

        if (! $policy) {
            $response->headers->set('Content-Security-Policy', $frameAncestors);
        } elseif (preg_match('/frame-ancestors[^;]*/', $policy)) {
            $response->headers->set('Content-Security-Policy', preg_replace('/frame-ancestors[^;]*/', $frameAncestors, $policy));
        } else {
            $response->headers->set('Content-Security-Policy', rtrim($policy, '; ').'; '.$frameAncestors);
        }
    }

    /** Full HTML documents only: not JSON, downloads, streams or Livewire updates. */
    private function isHtmlPage(Request $request, Response $response): bool
    {
        return ! $response instanceof BinaryFileResponse
            && ! $response instanceof StreamedResponse
            && ! $request->hasHeader('X-Livewire')
            && str_contains((string) $response->headers->get('Content-Type'), 'text/html')
            && str_contains((string) $response->getContent(), '</body>');
    }

    private function injectScript(Response $response, string $origin): void
    {
        $script = sprintf(
            '<script data-portal="%s">%s</script>',
            e($origin),
            file_get_contents(__DIR__.'/../../../resources/js/bridge.js'),
        );

        $content = (string) $response->getContent();
        $position = strripos($content, '</body>');

        $response->setContent(substr_replace($content, $script."\n", $position, 0));
    }
}
