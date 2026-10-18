<?php

namespace App\Http\Middleware;

use App\Models\SeoRedirect;
use Closure;
use Illuminate\Http\Request;

class HandleSeoRedirects
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->isMethod('GET')) {
            return $next($request);
        }

        $path = '/' . ltrim($request->path(), '/');

        $redirect = SeoRedirect::query()
            ->where('status', true)
            ->where(function ($query) use ($path, $request) {
                $query->where('old_url', $path)
                    ->orWhere('old_url', $request->fullUrl())
                    ->orWhere('old_url', ltrim($path, '/'));
            })
            ->first();

        if ($redirect) {
            $redirect->increment('hit_count');

            $statusCode = $redirect->type === '302' ? 302 : 301;
            return redirect($redirect->new_url, $statusCode);
        }

        return $next($request);
    }
}
