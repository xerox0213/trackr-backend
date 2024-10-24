<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureNoteOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $noteId = $request->route('id');
        $isOwner = Auth::user()->notes()->where('id', $noteId)->exists();

        if (!$isOwner) {
            return response()->json([
                'success' => false,
                'message' => 'Note not found'
            ], 404);
        }

        return $next($request);
    }
}
