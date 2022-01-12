<?php
return [
    'parameters' => [],
    'services' => [
        'App\\Controllers\\Controller' => [
            'App\\Contracts\\RequestInterface' => 'App\\Request'
        ],
        'App\\Services\\RouterService' => [

        ],
        'App\\Repositories\\AlbumRepository' => [

        ],
    ],
  'implementations' => [
      'App\\Contracts\\RequestInterface' => 'App\\Request',
      'App\\Contracts\\DatabaseInterface' => 'App\\Services\\DatabaseService',
      'App\\Contracts\\QueryBuilderInterface' => 'App\\Services\\QueryBuilderService',
  ]
];