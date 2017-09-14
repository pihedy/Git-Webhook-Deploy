<?php

return [
    'commands' => [
        'pairing' => [
            'mkdir tmp',
            'wget https://github.com/'
                . $data['repository']['full_name']
                . '/archive/'
                . DP_BRANCH
                . '.zip '
                . '-P tmp/ '
                . '--https-only',
            'unzip tmp/' . $commit . '.zip -d tmp/',
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
        ],
    ],
];
