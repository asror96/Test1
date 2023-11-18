<?php
namespace App\Http\Middleware;
use App\Models\User;
use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class AuthMiddleware
{
    public function handle(\Illuminate\Http\Request $request, Closure $next,$guard = null)
    {
        if(!$request->header('authorization')){
            return response()->json('Unauthorized.', 401);
        }
        try{
            $decode=JWT::decode($request->header('authorization'), new Key(env('JWT_SECRET'),'HS256'));
        }
        catch (Exception){
            return response()->json('Exception!',400);
        }
        $user=User::find($decode->sub);
        if($user!=null){
            if($user->remember_token==$request->header('authorization')){
                return $next($request);
            }
        }
        return response()->json('Unauthorized!.', 401);
    }
}
