<?php
return [
    'aliases' => [
        '@uploads' => '@frontend/web/uploads/',
        // movies PATHs
        '@episodes' => '@uploads/movies/episodes/',
        '@poster_small' => '@uploads/movies/posters/small/',
        '@poster_big' => '@uploads/movies/posters/big/',
        '@shot_thumb' => '@uploads/movies/shots/thumb/',
        '@shot_big' => '@uploads/movies/shots/big/',
        '@shot_original' => '@uploads/movies/shots/original/',
        '@subtitles' => '@uploads/movies/subtitles/',
        '@src' => '@uploads/movies/src/',
    ],
];

/*
    @app: Your application root directory (either frontend or backend or console depending on where you access it from)
    @vendor: Your vendor directory on your root app install directory
    @runtime: Your application files runtime/cache storage folder
    @web: Your application base url path
    @webroot: Your application web root
    @tests: Your console tests directory
    @common: Alias for your common root folder on your root app install directory
    @frontend: Alias for your frontend root folder on your root app install directory
    @backend: Alias for your backend root folder on your root app install directory
    @console: Alias for your console root folder on your root app install directory
 * */