<?php
namespace InstagramFeedApp;

require_once 'classes/InstagramFeed.php';
//Required to set these values
$tokenFile= 'token_html';
$cacheFile = 'ig_html_cache.txt';
$feedLimit = 6;
$igApp = new \InstagramFeedApp\InstagramFeed($tokenFile, $cacheFile, $feedLimit);
echo $igApp->getInstagramFeed('html', 'display: inline; margin: 8px 0;', 'col-sm-6');
