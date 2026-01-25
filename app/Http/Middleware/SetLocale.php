<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check session first (set by switcher)
        if (session()->has('locale')) {
            $locale = session('locale');
        }
        // 2. Check header or others
        else {
            $locale = $request->header('Accept-Language');

            // Fallbacks
            if (!$locale && $request->has('locale')) {
                $locale = $request->get('locale');
            }
            if (!$locale && $request->query('locale')) {
                $locale = $request->query('locale');
            }
            if (!$locale) {
                // Default based on browser/config or just en
                $locale = config('app.locale', 'en');
            }
        }

        // Validate
        if (!in_array($locale, ['en', 'ar'])) {
            $locale = 'en';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
