<?
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        // Jika pengguna sudah login
        if (Auth::check()) {
            // Jika sudah login, arahkan ke halaman yang sesuai (misalnya dashboard atau home)
            return redirect('/home'); // Atau redirect ke halaman yang sesuai
        }

        // Jika belum login, lanjutkan ke rute yang diminta
        return $next($request);
    }
}
