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
    $gitProfile = $fullName[1];
    $repo = $fullName[2];
    $shell = require_once DP_APP_PATH . '/commands.php';
    
    if(isset($data['zen']) || $dirStat == TRUE) {

        foreach($shell['commands']['pairing'] as $command) {
            shell_exec($command);
            header('HTTP/1.1 200 OK');
            echo "Pairing successful\n";
            return TRUE;
        }

    } elseif(isset($data['ref']) || $dirStat == FALSE) {
        
    }

    die();


    $commands = [
        'whoami',
        'mkdir tmp',
        'wget https://github.com/' 
            . $repo 
            . '/archive/' 
            . $commit 
            . '.zip ' 
            . '-P tmp/ ' 
            . '--https-only',
        'unzip tmp/' . $commit . '.zip -d tmp/',
    ];
    
    if(!empty($data['ref'])) {
        $refs = explode('/', $data['ref']);
    } else {
        foreach($settings['commands']['pairing'] as $command) {
            shell_exec($command);
        }
        header('HTTP/1.1 200 OK');
        echo "Pairing successful\n";
        return;
    }
    
    if($branch != $refs[2]) {
        $output = 'Fail: ' . $refs[2];
        return $output;
    }

    foreach($commands as $command) {
        shell_exec($command);
    }
    
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
