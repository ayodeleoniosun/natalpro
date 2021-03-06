<?php

namespace App\Modules\V1\Middleware;

use App\Modules\V1\Models\ActiveStatus;
use App\Modules\V1\Models\Role;
use App\Modules\V1\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CheckAdminLogin
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
        $session = session('admin');
            
        if ($session) {
            $admin = User::where([
                'id' => $session->id,
                'active_status' => ActiveStatus::ACTIVE
            ])->whereDate('token_expires_at', '>=', $now)->first();
            
            if ($admin && in_array(Role::ADMIN, $admin->userRoles())) {
                $request->merge(['auth_user' => $admin]);
                return $next($request);
            }

            $replaced = str_replace(url('/'), '', url()->current());
                
            if (($replaced == "") || ($replaced == "/")) {
                $replaced = '/dashboard';
            }

            session(['url' => $replaced]);
                
            return redirect('/admin');
        }

        return redirect('/admin');
    }
}
