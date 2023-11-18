<?php
use Illuminate\Support\Facades\Route;
/** @var \Laravel\Lumen\Routing\Router $router */
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Lottery_game_matchsController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix'=>'/api'], function () use ($router) {
    $router->post('/users/register','AuthController@register');
    $router->post('/users/login','AuthController@login');
});
$router->group(['prefix'=>'/api','middleware' => 'auth'], function () use ($router) {
    $router->put('/users/{id}','UserController@update');
    $router->delete('/users/{id}','UserController@destroy');
    $router->post('/lottery_game_match_users','Lottery_game_matchsController@register_in_match');
});
$router->get('/api/lottery_games','Lottery_gameController@index');
$router->get('/api/lottery_game_matchs','Lottery_game_matchsController@get_matches_game');


$router->group(['prefix'=>'/api','middleware' => 'admin'], function () use ($router) {
    $router->post('/lottery_game_matchs','Lottery_game_matchsController@create');
    $router->put('/lottery_game_matchs','Lottery_game_matchsController@end');
    $router->get('/users','UserController@index');

});
