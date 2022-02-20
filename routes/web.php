<?php

use App\Models\User;
use Avxman\Breadcrumb\Facades\BreadcrumbFacade;
use Avxman\Rating\Facades\RatingFacade;
use Avxman\NoFollow\Facades\NoFollowFacade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome')->with(['result'=>'Главная страница v1.0.9']);
});

Route::get('/jobs', function () {
    $data = collect(['name'=>"Alex", 'email'=>'text@text.text', 'password'=>Hash::make('alex')]);
    $faker = Faker\Factory::create();
    for ($count = 0; $count < 1; $count++){
        $data->put('email', $faker->freeEmail());
        \App\Jobs\CreateUserJob::dispatch($data);
    }
    return view('welcome');
});

Route::get('/breadcrumbs', function (){
    BreadcrumbFacade::save(
        collect()->push(
            ['url'=>'https://google.ua/', 'name'=>'Google'],
            ['url'=>null, 'name'=>'NEW']
        ),
        User::first());
    return BreadcrumbFacade::init(User::class, 2)->all()->toHtml();
});

Route::get('/ratings', function (){
    $user = User::first();
    RatingFacade::save(collect(['model'=>$user::class, 'model_id'=>$user->id, 'rating'=>1]), true);
    return RatingFacade::getOne($user)->toHtml();
});

Route::get('/rel-nofollow', function (){
    $user = User::first();
    $user->body = 'SDkjsldfj weijldfgjsd;fgolisjer ljsdfl kbjv<a href="https://test.test">test</a>blxcvkjbn lsktjh;lei thlgkfj df';
    if(NoFollowFacade::saveOne($user)) return NoFollowFacade::reset(true)->getString($user->body);
    return $user;
});

Route::get('/clear-cache', function (){
    return \Avxman\ClearCache\Facades\ClearCacheFacade::all()->getMessage();
});
