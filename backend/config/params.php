<?php
return [
    'adminEmail' => 'admin@example.com',

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
