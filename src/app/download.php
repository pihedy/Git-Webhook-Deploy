<?php

function archiveDownload($settings, $repoData) {

    if(isset($repoData['archive'])) {
        mkdir('tmp', 0777);
    } else {
        header('HTTP/1.1 304 Not Modified');
        $repoData['message'] = "Not Modified\n";
        return $repoData['message'];
    }

    $ch = curl_init();
    $source = 'https://github.com/' 
        . $repoData['gitProfile'] 
        . '/' 
        . $repoData['repo'] 
        . '/archive/' 
        . $repoData['archive'] 
        . '.zip';
    curl_setopt($ch, CURLOPT_URL, $source);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec ($ch);
    curl_close ($ch);

    $destination = 'tmp/' . $repoData['archive'] . ".zip";
    $file = fopen($destination, "w+");
    fputs($file, $data);
    fclose($file);

    return TRUE;

}
