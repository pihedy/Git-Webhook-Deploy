<?php

function branchValidation($json) {
    
    $repoData = [];

    $payload = json_decode($json, TRUE);

    foreach($payload as $key=>$value) {
        $data[$key] = $value;
    }

    $fullName = explode('/', $data['repository']['full_name']);
    $repoData['gitProfile'] = $fullName[0];
    $repoData['repo'] = $fullName[1];
    $data['after'] = isset($data['ref']) ? $data['after'] : "";

    if(isset($data['zen'])) {

        $repoData['archive'] = DP_BRANCH;
        $repoData['message'] = "Pairing successful\n";

    } elseif(isset($data['ref']) && $repoData['repo'] === DP_BRANCH) {

        $repoData['archive'] = $data['after'];
        $repoData['message'] = "Update successful\n";

    } else {

        $repoData['archive'] = NULL;

    }

    return $repoData;

}
