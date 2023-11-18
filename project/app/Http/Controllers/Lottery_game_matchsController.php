<?php
namespace App\Http\Controllers;
use App\Events\CustomEvent;
use App\Events\EndMatchEvent;
use App\Events\Event;
use App\Models\Lottery_game;
use App\Models\Lottery_game_match;
use App\Models\Lottery_game_match_user;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Auth\Events\Validated;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class Lottery_game_matchsController extends Controller
{

    public function get_matches_game(Request $request){
        $id=str_replace($request->getPathInfo().'?lottery_game_id=', '', $request->getRequestUri());
        $matches=Lottery_game_match::where('game_id',$id)->get();
        return response()->json( $matches,200);
    }
    public function create(Request $request){
        $data=$this->validate($request, [
            'game_id'=>'required|integer',
            'start_date'=>'required|date|after:today',
            'start_time'=>'required'
        ]);
        $match=Lottery_game_match::create($data);
        return response()->json($match,200);
    }

    public function end(Request $request){
        $data=$this->validate($request, [
            'match_id'=>'required|integer',
        ]);
        $match=Lottery_game_match::find($data['match_id']);
        $match->is_finished=true;
        event(new EndMatchEvent($match->id));
        $match->touch();
        $match->update();

        return response()->json('Match is ended!',200);
    }

    public function register_in_match(Request $request): \Illuminate\Http\JsonResponse
    {
        $decode=JWT::decode($request->header('authorization'), new Key(env('JWT_SECRET'),'HS256'));
        $data=$this->validate($request, [
            'match_id' => 'required|integer'
        ]);
        $match=Lottery_game_match::find($data['match_id']);
        if(!$match->is_finished){
            $user=User::find($decode->sub);
            $register_match=event(new CustomEvent($match->id,$user->id));
            return response()->json($register_match[0],200);
        }
        else{
            return response()->json('Match is ended!',400);
        }

    }

}
