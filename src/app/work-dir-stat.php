<?php

/**
 * workDirStat
 * @param mixed $workingDir 
 * @return mixed 
 */
function workDirStat($workingDir) {
    
    if(!is_readable($workingDir)) {
        return NULL;
    }

    $entry = readdir(opendir($workingDir));

    if($entry != "." && $entry != "..") {
        return FALSE;
    }

    return TRUE;

}
