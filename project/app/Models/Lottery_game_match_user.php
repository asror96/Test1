<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Lottery_game_match_user extends Model
{
    use  HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function lottery_game_match(){
        return $this->belongsTo(Lottery_game_match::class,'lottery_game_match_id','id');
    }
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [

    ];
}
