<?php

$settings = require_once DP_PATH_SRC . '/settings.php';
$ignoredFiles = require_once DP_PATH_SRC . '/ignored.php';

/* TODO: Ütemezés! */
date_default_timezone_set(TIME_ZONE);
set_time_limit(0);

/* TODO: Deploy esetén email küldése. */
$output = NULL;

/* Move public folder */
$publicPath = '';

require_once DP_PATH_APP . '/work-dir-stat.php';

if (workDirStat(WORKING_DIR) == NULL ) {
    header('HTTP/1.0 404 Not Found');
    echo 'Working directory not found!';
    die();
}

require_once DP_PATH_APP . '/handler.php';
require_once DP_PATH_APP . '/deploy.php';
require_once DP_PATH_APP . '/move.php';

/* Deploy files */

$dirStat = workDirStat(WORKING_DIR);
$json = handler($settings);
deploy($json, $settings, $dirStat, $ignoredFiles);

if (workDirStat(WORKING_DIR . 'public/') == TRUE) {
    $publicPath = 'public/';
    folderMove($settings, $publicPath);
} elseif (workDirStat(WORKING_DIR . 'src/public/') == TRUE) {
    $publicPath = 'src/public/';
    folderMove($settings, $publicPath);
} else {
    $publicPath = '';
    folderMove($settings, $publicPath);
}
