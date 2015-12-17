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
    $giphy = file_get_contents('http://api.giphy.com/v1/gifs/search?q='.$request->get('text').'&api_key=dc6zaTOxFJmzC');

    return (new Response(
        {
            "attachments": [
                {
                    "fallback": "Required plain-text summary of the attachment.",

                    "color": "#36a64f",

                    "pretext": "Optional text that appears above the attachment block",

                    "author_name": "Bobby Tables",
                    "author_link": "http://flickr.com/bobby/",
                    "author_icon": "http://flickr.com/icons/bobby.jpg",

                    "title": "Slack API Documentation",
                    "title_link": "https://api.slack.com/",

                    "text": "Optional text that appears within the attachment",

                    "fields": [
                        {
                            "title": "Priority",
                            "value": "High",
                            "short": false
                        }
                    ],

                    "image_url": $giphy->data->url,
                    "thumb_url": $giphy->data->url
                }
            ]
        }
    , 200));

});
