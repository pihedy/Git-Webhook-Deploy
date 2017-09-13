<?php

/**
 * handler
 * @return mixed 
 */
function handler() 
{

    $hookSecret = 'pihedmond';
    
    set_error_handler(function($severity, $message, $file, $line) {
        throw new \ErrorException($message, 0, $severity, $file, $line);
    });
    
    set_exception_handler(function($e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo "Error on line {$e->getLine()}: " . htmlSpecialChars($e->getMessage());
        die();
    });
    $rawPost = NULL;
    
    if($hookSecret !== NULL) {
        if(!isset($_SERVER['HTTP_X_HUB_SIGNATURE'])){
            echo "Missing: HTTP Header X-Hub-Signature\n";
        } elseif (!extension_loaded('hash')) {
            echo "Missing: HASH - dont validity the secret key!\n";
        }
    
        list($algo, $hash) = explode('=', $_SERVER['HTTP_X_HUB_SIGNATURE'], 2) + array('', '');
        if(!in_array($algo, hash_algos(), TRUE)) {
            echo "This algorith not supported!\n";
        }
    
        $rawPost = file_get_contents('php://input');
        if($hash !== hash_hmac($algo, $rawPost, $hookSecret)) {
            header('HTTP/1.1 403 Forbidden');
            echo "Hook secret dont match!\n";
        }
    }

    if(!isset($_SERVER['CONTENT_TYPE'])) {
        echo "Missing: Http Content Type\n";
        
    } elseif (!isset($_SERVER['HTTP_X_GITHUB_EVENT'])) {
        echo "Missing: Http X-Github Event\n";
    }
    
    switch($_SERVER['CONTENT_TYPE']) {

        case 'application/json':
            $json = $rawPost ?: file_get_contents('php://input');
            break;
        
        case 'application/x-www-form-urlencoded':
            $json = $_POST['payload'];
            break;

        default:
            echo "Unsupported content\n";

    }

    switch(strtolower($_SERVER['HTTP_X_GITHUB_EVENT'])) {

        case 'push':
            echo "pong\n";
            break;
        
        default: 
            header('HTTP/1.0 404 Not Found');

    }

    return $json;
    
}
