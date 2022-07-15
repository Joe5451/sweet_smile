<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AdminToken;

class EnsureAdminTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (is_null($token)) return $this->returnFailResponse();

        $admin_token = AdminToken::where('token', $token)->where('expires_in', '>', date('Y-m-d H:i:s'))->take(1)->get();

        if (count($admin_token) == 0) return $this->returnFailResponse();
        else return $next($request);
    }

    private function returnFailResponse() {
        return response()->json([
            'status' => 'fail',
            'message' => 'token 驗證失敗'
        ]);
    }
}
