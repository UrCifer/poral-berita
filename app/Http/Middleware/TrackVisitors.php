<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;

class TrackVisitors
{
    public function handle(Request $request, Closure $next): Response
    {
        // Simpan data pengunjung berdasarkan IP dan browser
        Visitor::create([
            'ip_address' => $request->ip(),
            'browser' => $request->header('User-Agent'),
        ]);

        return $next($request);
    }
}
