<?php

/**
 * deploy
 * @param mixed $ignoredFiles 
 * @return mixed 
 */
 function deploy($json, $ignoredFiles = [])
 {
     $branch = 'master';
     $workingDir = __DIR__ . '/../public/';
     $output = NULL;
 
     $payload = json_decode($json, TRUE);
 
     foreach($payload as $key=>$value) {
         $data[$key] = $value;
     }
     
     $refs = explode('/', $data['ref']);
     
     if($branch != $refs[2]) {
         $output = 'Fail: ' . $refs[2];
         return $output;
     }
 
     $commit = $data['after'];
     $repo = $data['repository']['full_name'];
     
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
             'cp tmp/' . $data['repository']['name'] . '-' . $commit . '/' 
             . $file 
             . ' ' 
             . $workingDir
         );
     }
     
     $removed = $data['head_commit']['removed'];
 
     return true;
 }
