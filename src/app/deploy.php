<?php

 /**
  * deploy
  * @param mixed $json 
  * @param mixed $settings 
  * @param mixed $ignoredFiles 
  * @return mixed 
  */
 function deploy($json, $settings, $dirStat, $ignoredFiles)
 {

    $payload = json_decode($json, TRUE);

    foreach($payload as $key=>$value) {
        $data[$key] = $value;
    }
    
    $fullName = explode('/', $data['repository']['full_name']);
    $gitProfile = $fullName[0];
    $repo = $fullName[1];
    $data['after'] = isset($data['ref']) ? $data['after'] : "";

    $shell = require_once DP_PATH_APP . '/commands.php';
    
    if(isset($data['zen']) || $dirStat === false) {

        foreach($shell['pairing'] as $command) {
            shell_exec($command);
        }
        header('HTTP/1.1 200 OK');
        echo "Pairing successful\n";

    } elseif(isset($data['ref']) && $dirStat === true) {

        $refs = explode('/', $data['ref']);

        if($refs[2] === DP_BRANCH) {

            foreach($shell['update'] as $command) {
                shell_exec($command);
            }
            header('HTTP/1.1 200 OK');
            echo "Update successful\n";

        } else {

            header('HTTP/1.1 304 Not Modified');
            echo "Not Modified\n";

        }

    }
    return TRUE;
    
    $newFiles = array_unique(
        array_merge(
            $data['head_commit']['added'], 
            $data['head_commit']['modified']
        ), 
        SORT_REGULAR
    );

    $files = array_diff($newFiles, $ignoredFiles);

    foreach($files as $file) {
        shell_exec(
            'cp -a tmp/' . $data['repository']['name'] . '-' . $commit . '/' 
            . $file 
            . ' ' 
            . $workingDir
        );
    }
    
    $removed = $data['head_commit']['removed'];

    return true;
 }
