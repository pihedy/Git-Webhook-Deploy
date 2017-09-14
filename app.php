<?php

define('DP_PATH', __DIR__);
define('DP_APP_PATH', DP_PATH . '/src');

$settings = require_once DP_APP_PATH . '/settings.php';
$ignoredFiles = require_once DP_APP_PATH . '/ignored.php';

/* TODO: Ütemezés! */
date_default_timezone_set(TIME_ZONE);
set_time_limit(0);

/* TODO: Deploy esetén email küldése. */
$output = NULL;

require_once DP_APP_PATH . '/work-dir-stat.php';

if(workDirStat(WORKING_DIR) == NULL ) {
    header('HTTP/1.0 404 Not Found');
    echo 'Working directory not found!';
    die();
}

require_once DP_APP_PATH . '/handler.php';
require_once DP_APP_PATH . '/deploy.php';

$dirStat = workDirStat(WORKING_DIR);
$json = handler($settings);
deploy($json, $settings, $dirStat, $ignoredFiles);

/* NOTE: piszkozat */
/* $file = fopen(__DIR__ . '/saved.txt', 'w') or die('N/A');
    
    fwrite($file, $json);
    fclose($file); */ 
