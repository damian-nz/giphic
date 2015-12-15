<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

$app->get('/', function () use ($app) {
    return $app->welcome();
});

$app->get('/slack', function () use ($app) {
    return (new Response('Hello Slack', 200));
});

$app->post('/slack', function (Request $request) use ($app) {
    return (new Response('You sent me: '.json_encode($request->all()), 200));
});
