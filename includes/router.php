<?php

declare(strict_types=1);

// Constant values for router
const ALLOW_METHODS = ['GET', 'POST'];
const INDEX_URI = '';
const HOME_ROUTE = 'home';

// Normalize URI
function normalizeUri(string $uri): string
{
    $uri = strtok($uri, '?');
    // Convert to lower case and remove trailing slashes
    $uri = strtolower(trim($uri, '/'));
    $uri = strtolower(trim($uri, '#'));
    // Check if uri is empty and return index.php
    
    return $uri == INDEX_URI ? HOME_ROUTE : $uri;
}

// Page not found function
function notFound(){
    http_response_code(404);
    echo "404 Not Found";
    exit;
}

function badRequest(string $message = 'Bad request'): void
{
    http_response_code(400);
    echo $message;
    exit;
}


function getFilePath(string $uri, string $method) : string {
    return ROUTE_DIR. '/' . normalizeUri($uri) . '_' . strtolower($method) . '.php' ;
}

// Router handler
//dispatchแปลว่าส่งต่อ
function dispatch(string $uri, string $method) : void {
    // 1) Normalize the URI
    $uri = normalizeUri($uri);
    // 2) Handle GET and POST requests
    if (!in_array(strtoupper($method), ALLOW_METHODS)) {
        notFound();
    }
    // 3) Link to php files
    $filePath = getFilePath($uri, $method);
    if(file_exists($filePath)){
        include($filePath);
        return;
    } else {
        notFound();
    }
}

// includes/routes.php 
