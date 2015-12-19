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
    $giphyURL = 'http://api.giphy.com/v1/gifs/search?q='.urlencode($request->get('text')).'&api_key=dc6zaTOxFJmzC';

    $giphyResponse[] = \Httpful\Request::get($giphyURL)
    ->expectsJson()
    ->send();

    return response()->json([
        "response_type" => 'ephemeral',
        "unfurl_media"=> true,
        "text" => "Click the title of one to post it",
        "attachments" => [
                [
                    "title" => 'Option One',
                    "title_link": "https://api.slack.com/",
                    "image_url" => $giphyResponse[0]->body->data[0]->images->fixed_height_small->url
                ],
                [
                    "title" => 'Option Two',
                    "title_link": "https://api.slack.com/",
                    "image_url" => $giphyResponse[0]->body->data[1]->images->fixed_height_small->url
                ],
                [
                    "title" => 'Option Three',
                    "title_link": "https://api.slack.com/",
                    "image_url" => $giphyResponse[0]->body->data[2]->images->fixed_height_small->url
                ],
        ]
    ]);
});
