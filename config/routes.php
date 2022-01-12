<?php
return [
    '/' => [
        'method' => 'GET',
        'call' => 'PageController@index'
    ],
    '/albums' => [
        'method' => 'GET',
        'call' => 'AlbumController@list'
    ],
    '/albums/{id}' => [
        'method' => 'GET',
        'call' => 'AlbumController@show',
        'params' => [
            'id' => '/^[0-9]*/'
        ]
    ],
    '/albums/create' => [
        'method' => 'POST',
        'call' => 'AlbumController@create'
    ],
    '/albums/update' => [
        'method' => 'POST',
        'call' => 'AlbumController@update'
    ],
    '/albums/delete' => [
        'method' => 'POST',
        'call' => 'AlbumController@delete'
    ]
];
