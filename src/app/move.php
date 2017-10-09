<?php 

function folderMove($settings, $publicPath)
{
    if (empty($publicPath)) {
        return;
    } else {
        shell_exec('mv ' . WORKING_DIR . $publicPath . ' ' . PUB_WORK_DIR);
    }

}
