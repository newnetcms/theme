<?php

namespace Newnet\Theme\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!config('cms.theme.maintenance_mode')) {
            return $next($request);
        }

        $admin_prefix = config('core.admin_prefix');
        if ($request->is($admin_prefix.'*')) {
            return $next($request);
        } else {
            if (Auth::guard('admin')->check()) {
                return $next($request);
            } else {
                return response(
                    view('maintenance'),
                    503,
                    $this->getHeaders([])
                );
            }
        }
    }

    protected function getHeaders($data)
    {
        $headers = isset($data['retry']) ? ['Retry-After' => $data['retry']] : [];

        if (isset($data['refresh'])) {
            $headers['Refresh'] = $data['refresh'];
        }

        return $headers;
    }
}
