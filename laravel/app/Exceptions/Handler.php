<?php

namespace App\Exceptions;

use App\Models\Seo404Log;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            $this->logSeo404($request);
            // Returning null/void here lets Laravel fall through to its
            // normal 404 rendering — this hook only observes the request.
        });
    }

    /**
     * Record a broken URL for the redirect manager's 404 log, so the SEO
     * team can see which dead links visitors actually reach.
     */
    private function logSeo404(Request $request): void
    {
        if (!$request->isMethod('GET')) {
            return;
        }

        try {
            $url = '/' . ltrim($request->path(), '/');

            $log = Seo404Log::query()->where('url', $url)->first();

            if ($log) {
                $log->increment('hit_count');
                $log->last_seen_at = now();
                $log->referrer = $request->headers->get('referer') ?: $log->referrer;
                $log->user_agent = $request->userAgent() ?: $log->user_agent;
                $log->save();
            } else {
                Seo404Log::create([
                    'url' => $url,
                    'referrer' => $request->headers->get('referer'),
                    'user_agent' => $request->userAgent(),
                    'hit_count' => 1,
                    'last_seen_at' => now(),
                ]);
            }
        } catch (Throwable $e) {
            // Never let 404 logging itself break the 404 response.
        }
    }
}
