<?php

 /**
  * deploy
  * @param mixed $json 
  * @param mixed $settings 
  * @param mixed $dirStat 
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
    
    if(isset($data['zen']) || $dirStat === FALSE) {

        foreach($shell['pairing'] as $command) {
            shell_exec($command);
        }
        echo "Pairing successful\n";

    } elseif(isset($data['ref']) && $dirStat === TRUE) {

        $refs = explode('/', $data['ref']);

        if($refs[2] === DP_BRANCH) {

            foreach($shell['update'] as $command) {
                shell_exec($command);
            }

            foreach($data['head_commit']['removed'] as $removed) {
                array_map('unlink', glob(WORKING_DIR . $removed));
            }

            echo "Update successful\n";

        } else {

            header('HTTP/1.1 304 Not Modified');
            echo "Not Modified\n";

        }

    }
    return TRUE;
 }
