<?php

$settings = require_once DP_PATH_SRC . '/settings.php';
$ignoredFiles = require_once DP_PATH_SRC . '/ignored.php';

/* TODO: Ütemezés! */
date_default_timezone_set(TIME_ZONE);
set_time_limit(0);

/* TODO: Deploy esetén email küldése. */
$output = NULL;

require_once DP_PATH_APP . '/work-dir-stat.php';

if(workDirStat(WORKING_DIR) == NULL ) {
    header('HTTP/1.0 404 Not Found');
    echo 'Working directory not found!';
    die();
}

require_once DP_PATH_APP . '/handler.php';
require_once DP_PATH_APP . '/validation.php';
require_once DP_PATH_APP . '/download.php';
require_once DP_PATH_APP . '/deploy.php';

$dirStat = workDirStat(WORKING_DIR);
$json = handler($settings);
$repoData = branchValidation($json);
archiveDownload($settings, $repoData);
die('The End');
deploy($json, $settings, $dirStat, $ignoredFiles);
