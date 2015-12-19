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
    $giphyURL = 'http://api.giphy.com/v1/gifs/search?q='.$request->get('text').'&api_key=dc6zaTOxFJmzC';

    $giphyResponse = [];

    $giphyResponse[] = \Httpful\Request::get($giphyURL)
    ->expectsJson()
    ->send();

    $giphyResponse[] = \Httpful\Request::get($giphyURL)
    ->expectsJson()
    ->send();

    $giphyResponse[] = \Httpful\Request::get($giphyURL)
    ->expectsJson()
    ->send();

    return response()->json([
        "response_type" => 'ephemeral',
        "unfurl_media"=> true,
        "text" => "<".$giphyResponse[0]->body->data[0]->url.">\n <".$giphyResponse[1]->body->data[0]->url.">\n <".$giphyResponse[2]->body->data[0]->url."> "
    ]);
});
