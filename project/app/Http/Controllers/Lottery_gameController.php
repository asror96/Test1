<?php
namespace App\Http\Controllers;
use App\Models\Lottery_game;
class Lottery_gameController extends Controller
{
    public function index(){
        $games=Lottery_game::all();
        foreach ($games as $game){
            $data[]= collect([
                'id'=>$game->id,
                'name'=>$game->name,
                'gamer_count'=>$game->gamer_count,
                'reward_points'=>$game->reward_count,
                'matchs'=>$game->matchs
            ]);

        }
        return response()->json($data,200);
    }
}

