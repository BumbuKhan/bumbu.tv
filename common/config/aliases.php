<?php
return [
    'aliases' => [
        '@uploads' => '@frontend/web/uploads/',
        // movies PATHs
        '@poster_small' => '@uploads/movies/posters/small/',    /* Movie's small poster */
        '@poster_big' => '@uploads/movies/posters/big/',        /* Movie's big poster */

        '@gallery_thumb' => '@uploads/movies/gallery/thumb/',        /* Movie's photo gallery */
        '@gallery_big' => '@uploads/movies/gallery/big/',            /* Movie's photo gallery */

        '@subtitles' => '@uploads/movies/subtitles/',           /* Subtitles for movie */
        '@episodes' => '@uploads/movies/episodes/',             /* Episodes for series */
        '@src' => '@uploads/movies/src/',                       /* Movie itself */


        // movie's stuff URLs
        '@uploads_url' => '@frontend_url/uploads',
        '@poster_small_url' => '@uploads_url/movies/posters/small/',
        '@poster_big_url' => '@uploads_url/movies/posters/big/',

        '@gallery_thumb_url' => '@uploads_url/movies/gallery/thumb/',
        '@gallery_big_url' => '@uploads_url/movies/gallery/big/',

        '@subtitles_url' => '@uploads_url/movies/subtitles/',
        '@episodes_url' => '@uploads_url/movies/episodes/',
        '@src_url' => '@uploads_url/movies/src/',
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