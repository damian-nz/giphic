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
    // $giphicURL = 'http://giphic.acropixel.com/post_message?gif=';
    $giphyResponse = getGifsByKeyword($request->get('text'));

    return response()->json([
        "response_type" => 'ephemeral',
        "unfurl_media"=> true,
        "text" => "Click the title of one to post it",
        "attachments" => [
                [
                    "title" => 'Option One',
                    "image_url" => $giphyResponse->body->data[0]->images->fixed_height_small->url
                ],
                [
                    "title" => 'Option Two',
                    "image_url" => $giphyResponse->body->data[1]->images->fixed_height_small->url
                ],
                [
                    "title" => 'Option Three',
                    "image_url" => $giphyResponse->body->data[2]->images->fixed_height_small->url
                ],
                [
                    "title" => 'Option Four',
                    "image_url" => $giphyResponse->body->data[3]->images->fixed_height_small->url
                ],
        ]
    ]);
});

$app->post('/post_message', function (Request $request) use ($app) {

    // split into number, space, keyword
    preg_match("/(\d+)(\s+)(.+)/", $request->get('text'), $matches);
    $giphyResponse = getGifsByKeyword($matches[3]);
    $gifPosition = $matches[1] - 1;

    return response()->json([
        "response_type" => 'in_channel',
        "unfurl_media"=> true,
        "attachments" => [
                [
                    "title" => $giphyResponse->body->data[$gifPosition]->images->fixed_height_small->url,
                    "image_url" => $giphyResponse->body->data[$gifPosition]->images->fixed_height_small->url
                ],
        ]
    ]);
});

// How I wish I could do it
// $app->get('/post_message', function (\Request $request) use ($app) {
//     $url = $request->get('gif');
//     return response()->json([
//         "response_type" => 'in_channel',
//         "unfurl_media"=> true,
//         "attachments" => [
//                 [
//                     "image_url" => $url
//                 ],
//         ]
//     ]);
// });

function getGifsByKeyword($keyword)
{
    $giphyURL = 'http://api.giphy.com/v1/gifs/search?q='.urlencode($keyword).'&api_key=dc6zaTOxFJmzC';

    return \Httpful\Request::get($giphyURL)
    ->expectsJson()
    ->send();
}
