<?php
$gethost = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:(isset($_SERVER['APP_HOST'])?$_SERVER['APP_HOST']:env('APP_HOST'));
$base_url = isset($_SERVER['HTTP_X_FORWARDED_PROTO'])?$_SERVER['HTTP_X_FORWARDED_PROTO']:(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : (isset($_SERVER['REQUEST_SCHEME'])?$_SERVER['REQUEST_SCHEME']:'http'));
$base_url .= '://'.$gethost;
defined("ASSET_URL") ? null : define("ASSET_URL", $base_url.'/');