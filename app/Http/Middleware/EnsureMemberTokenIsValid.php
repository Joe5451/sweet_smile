<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Member;

class EnsureMemberTokenIsValid
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

        if (is_null($token)) return $this->returnInvalidResponse();

        $member = Member::where('token', $token)->where('token_expires_in', '>', date('Y-m-d H:i:s'))->take(1)->get();

        if (count($member) == 0) return $this->returnInvalidResponse();
        else return $next($request);
    }

    private function returnInvalidResponse() {
        return response()->json([
            'status' => 'token_invalid',
        ]);
    }
}
