<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureHabitOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $habitId = $request->route('id');
        $isOwner = Auth::user()->habits()->where('id', $habitId)->exists();
        if (!$isOwner) {
            return response()->json([
                'success' => false,
                'message' => 'Habit not found'
            ], 401);
        }
        return $next($request);
    }
}
