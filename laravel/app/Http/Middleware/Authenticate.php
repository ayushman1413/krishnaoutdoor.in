<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // The "admin" guard is the only one actually protecting routes in this
        // app (see routes/admin.php), so route unauthenticated visitors there.
        return $request->expectsJson() ? null : route('admin.view.login');
    }
}
