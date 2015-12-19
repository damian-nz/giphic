<?php

use \Httpful\Request;
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
    $giphyURL = 'http://api.giphy.com/v1/gifs/search?q='.$request->get('text').'&api_key=dc6zaTOxFJmzC';
    $giphyResponse = $request->get($giphyURL)
    ->expectsJson()
    ->send();

    return response()->json([
        "response_type" => 'ephemeral',
        "unfurl_media"=> true,
        "text" => "<".$giphyResponse->body->data[0]->url.">"
    ]);
});
