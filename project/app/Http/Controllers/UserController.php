<?php

namespace App\Http\Controllers;

use App\Models\Lottery_game_match;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request ,$id){
        $decode=JWT::decode($request->header('authorization'), new Key(env('JWT_SECRET'),'HS256'));
        $data=$this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ]);
        if($id==$decode->sub){
            $user=User::find($id);
            $user->first_name=$data['first_name'];
            $user->last_name=$data['last_name'];
            $user->update();
            return response()->json($user,200);
        }
        return response()->json('Unauthorized!',401);
    }

    public function destroy(Request $request,$id){
        $decode=JWT::decode($request->header('authorization'), new Key(env('JWT_SECRET'),'HS256'));
        if($id==$decode->sub){
            $user=User::find($id);
            $user->delete();
            return response()->json('Deleted!',200);
        }
        return response()->json('Unauthorized!',401);
    }

    public function index(){
        $users=User::all();
        foreach ($users as $user){
            $user['win_matches']=$user->win_matches;
        }
        return response()->json($users,200);
    }
}
