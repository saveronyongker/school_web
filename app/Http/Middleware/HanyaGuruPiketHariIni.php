<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class HanyaGuruPiketHariIni
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
         if (!Auth::check()) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');

        }
        // if (!auth()->check()) {
        //     return redirect('/login');
        // }

        $user = auth()->user();
        $today = now()->format('Y-m-d');

        $isPiket = \App\Models\JadwalPiket::where('tanggal', $today)
            ->where('user_id', $user->id)
            ->exists();

        if (!$isPiket) {
            abort(403, 'Anda tidak bertugas sebagai guru piket hari ini.');
        }

        return $next($request);
    }
}
