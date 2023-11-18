<?php

namespace Database\Factories;

use App\Models\Lottery_game;
use Illuminate\Database\Eloquent\Factories\Factory;

class Lottery_gameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lottery_game::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'gamer_count'=>(rand(1,10))*10,
            'reward_points'=>rand(1,10)
        ];
    }
}
