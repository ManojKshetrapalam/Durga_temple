<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockScrapers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userAgent = $request->header('User-Agent');

        $scrapers = [
            'curl',
            'wget',
            'python-requests',
            'scrapy',
            'postman',
            'insomnia',
            'headless',
            'phantomjs',
            'selenium',
            'webdriver',
            'crawler',
            'spider',
            'bot',
        ];

        if ($userAgent) {
            foreach ($scrapers as $bot) {
                if (stripos($userAgent, $bot) !== false) {
                    return response('Scraping is not allowed. Please contact administrator for a copy of this project.', 403);
                }
            }
        }

        return $next($request);
    }
}
