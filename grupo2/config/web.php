<?php
function getBaseUrl()
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $script = dirname($_SERVER['SCRIPT_NAME']);
    return "$protocol://$host$script";
}

function getBasePath()
{
    $script = dirname($_SERVER['SCRIPT_NAME']);
    return "$script";
}

define('BASE_URL', getBaseUrl());
define('BASE_PATH', getBasePath());
