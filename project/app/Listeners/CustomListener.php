<?php
namespace App\Listeners;
use App\Events\CustomEvent;
use App\Models\Lottery_game;
use App\Models\Lottery_game_match_user;
class CustomListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CustomEvent  $event
     * @return string
     */
    public function handle(CustomEvent $event)
    {
        $data=Lottery_game_match_user::where('lottery_game_match_id',$event->id)->where('user_id',$event->user_id)->get();
        $register_in_match=Lottery_game_match_user::where('lottery_game_match_id',$event->id)->get();
        $game=Lottery_game::find($event->id);

        if(count($register_in_match)>=$game->gamer_count){
            return 'The number of players is limited';
        }
        if(count($data)==0){
            return Lottery_game_match_user::create([
            "user_id"=>$event->user_id,
            "lottery_game_match_id"=>$event->id
            ]);
        }

        return $data[0];
    }
}
