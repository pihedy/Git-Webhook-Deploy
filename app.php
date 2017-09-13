<?php

/* TODO: Ütemezés! */
date_default_timezone_set('Europe/Budapest');
set_time_limit(0);

/* TODO: Deploy esetén email küldése. */
$errorEmail = 'pihedy@gmail.com';
$output = NULL;

/* TODO: settings.php-t bevezetni! */

require_once('handler.php');
require_once('deploy.php');

$json = handler();
deploy($json, array('valami.php'));

/* NOTE: piszkozat */
/* $file = fopen(__DIR__ . '/saved.txt', 'w') or die('N/A');
    
    fwrite($file, $json);
    fclose($file); */ 
