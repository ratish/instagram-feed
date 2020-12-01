<?php
namespace InstagramFeedApp;

require_once 'classes/InstagramFeed.php';
//Required to set these values
$tokenFile= 'token_nohtml';
$cacheFile = 'ig_nohtml_cache.txt';
$feedLimit = 3;
$igApp = new \InstagramFeedApp\InstagramFeed($tokenFile, $cacheFile, $feedLimit);
$feeds = $igApp->getInstagramFeed('nohtml');
if ($feeds == '') {
    return 0;
}
?>
<div class="col-sm-12" style="padding: 10px;">
    <a href="<?= $feeds[0]['link'] ?>"><img src="<?= $feeds[0]['image'] ?>" alt="<?= $feeds[0]['caption'] ?>" /></a>
</div>
<div class="col-sm-6" style="padding: 10px;">
    <a href="<?= $feeds[1]['link'] ?>"><img src="<?= $feeds[1]['image'] ?>" alt="<?= $feeds[1]['caption'] ?>" /></a>
</div>
<div class="col-sm-6" style="padding: 10px;">
    <a href="<?= $feeds[2]['link'] ?>"><img src="<?= $feeds[2]['image'] ?>" alt="<?= $feeds[2]['caption'] ?>" /></a>
</div>
