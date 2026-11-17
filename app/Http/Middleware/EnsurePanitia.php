<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class EnsurePanitia {
 public function handle(Request $request, Closure $next): Response {
  abort_unless($request->user()?->isPanitia(),403,'Halaman ini hanya dapat diakses panitia.');
  return $next($request);
 }
}
