<?php
namespace App\Listeners;
use App\Events\EndMatchEvent;
use App\Models\Lottery_game_match;
use App\Models\Lottery_game_match_user;
use App\Models\User;

class EndMatchListener
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
     * @param  \App\Events\EndMatchEvent  $event
     * @return void
     */
    public function handle(EndMatchEvent $event)
    {
        $users=Lottery_game_match_user::where('lottery_game_match_id',$event->id)->get('user_id');
        $random_user=rand(0,(count($users)-1));
        $match=Lottery_game_match::find($event->id);
        $match->winner_id=$users[$random_user]->user_id;
        $match->update();
        $user=User::find($users[$random_user]->user_id);
        $user->point=($user->point)+($match->game->reward_points);
        $user->update();
    }
}
