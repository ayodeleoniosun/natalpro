<?php

namespace App\Modules\V1\Middleware;

use App\Modules\V1\Models\ActiveStatus;
use App\Modules\V1\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CheckUserLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $now = Carbon::now()->toDateTimeString();
        $session = session('user');
            
        if ($session) {
            $user = User::where([
                'id' => $session->id,
                'role_type' => 'user',
                'active_status' => ActiveStatus::ACTIVE
            ])->whereDate('token_expires_at', '>=', $now)->first();
            
            if (!$user) {
                $replaced = str_replace(url('/'), '', url()->current());
                
                if (($replaced == "") || ($replaced == "/")) {
                    $replaced = '/dashboard';
                }

                session(['url' => $replaced]);
                
                return redirect('/user');
            }

            $request->merge(['auth_user' => $user]);

            return $next($request);
        }

        return redirect('/user');
    }
}
