<?php
return [
    'adminEmail' => 'admin@example.com',

    // scenarios
    'SCENARIO_MOVIES_MOVIE_CREATE' => 'movie_create',
    'SCENARIO_MOVIES_SERIES_CREATE' => 'series_create',
    'SCENARIO_MOVIES_SERIES_EPISODE_CREATE' => 'series_episode_create',
    'SCENARIO_MOVIES_CARTOON_CREATE' => 'cartoon_create',
    'SCENARIO_MOVIES_TED_CREATE' => 'ted_create',
    'SCENARIO_MOVIES_DEFAULT' => 'default',

    'SCENARIO_MOVIES_MOVIE_EDIT' => 'movie_edit',
    'SCENARIO_MOVIES_SERIES_EDIT' => 'series_edit',
    'SCENARIO_MOVIES_SERIES_EPISODE_EDIT' => 'series_episode_edit',
    'SCENARIO_MOVIES_CARTOON_EDIT' => 'cartoon_edit',
    'SCENARIO_MOVIES_TED_EDIT' => 'ted_edit',

    // params for movie's mediafiles
    'poster_small_width' => 200,
    'poster_small_height' => 300,
    'poster_small_anchor' => 'center', /*  'center', 'top', 'bottom', 'left', 'right', 'top left', 'top right', 'bottom left', 'bottom right' (default 'center') */

    'poster_big_width' => 980,
    'poster_big_height' => 350,
    'poster_big_anchor' => 'top', /*  'center', 'top', 'bottom', 'left', 'right', 'top left', 'top right', 'bottom left', 'bottom right' (default 'center') */
    'poster_big_blur_filter' => 'gaussian', /* 'selective', 'gaussian' (default 'gaussian'). */
    'poster_big_blur_filter_passes' => 35, /* The number of time to apply the filter, enhancing the effect (default 1). */
    'poster_big_blur_filter_darken' => 10,
];
