<?php

return [
    'pairing' => [
        'chmod 777' . WORKING_DIR . ' -R',
        'mkdir tmp',
        'cd tmp/ && wget https://github.com/'
            . $data['repository']['full_name']
            . '/archive/'
            . DP_BRANCH
            . '.zip '
            . '--https-only',
        'unzip tmp/' . DP_BRANCH . '.zip -d tmp/',
        'cd tmp/'
            . $data['repository']['name'] 
            . '-' 
            . DP_BRANCH
            . '/ && find . -type f -exec zip ' 
            . DP_BRANCH
            . '.zip {} +',
        'cp tmp/'
            . $data['repository']['name'] 
            . '-' 
            . DP_BRANCH
            . '/'
            . DP_BRANCH
            . '.zip '
            . WORKING_DIR,
        'cd ' . WORKING_DIR . ' && unzip ' . DP_BRANCH . '.zip',
        'cd ' . WORKING_DIR . ' && rm ' . DP_BRANCH . '.zip',
        'rm -rf tmp/',
    ],
];
