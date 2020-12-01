<?php
namespace InstagramFeedApp;

require_once 'Curl.php';

define('TWENTY_FOUR_HOURS', 86400);
define('INSTAGRAM_REFRESH_TOKEN_API_URL', 'https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token');
define('INSTAGRAM_FEED_API_URL', 'https://graph.instagram.com/me/media?fields=caption,media_url,media_type,thumbnail_url,permalink');
//fields=id,caption,media_type,media_url,permalink,thumbnail_url,username,timestamp

class InstagramFeed
{
    protected $tokenFile;
	protected $cacheFile;
	protected $feedLimit;
	protected $defaultCaption = 'My Instagram Feed';
    protected $accessToken;

	public function __construct($tokenFile, $cacheFile, $feedLimit = '4')
	{
        $this->tokenFile = $tokenFile;
		$this->cacheFile = $cacheFile;
		$this->feedLimit = $feedLimit;
	}

    public function getInstagramFeed($outputFormat = 'html', $cssStyle = 'width:120px; height:120px; display: inline; margin-left:15px; padding-bottom: 10px; padding-right:10px;', $cssClass = '')
	{
        $feeds = $this->getFeedFromCache();

        if (! $feeds) {
            $this->accessToken = $this->getAccessToken();
            $feeds = Curl::request(INSTAGRAM_FEED_API_URL . "&limit={$this->feedLimit}&access_token={$this->accessToken}");
            if (isset($feeds->error)) {
                return '';
            }
            file_put_contents($this->cacheFile, serialize($feeds));
        }
		$formattedFeed = $this->getFormattedFeed($feeds);

        return ($outputFormat == 'html') ? $this->getHtmlFeed($formattedFeed, $cssStyle, $cssClass) : $formattedFeed;
    }

	private function getHtmlFeed($feeds, $cssStyle, $cssClass)
    {
    	$htmlFeed = '';
		foreach ($feeds as $feed) {
            $htmlFeed .= "<a href=\"{$feed['link']}\"><img class=\"{$cssClass}\" style=\"{$cssStyle}\" src=\"{$feed['image']}\" alt=\"{$feed['caption']}\" /></a>";
    	}

    	return $htmlFeed;
    }

    private function getFormattedFeed($feeds)
    {
    	$formattedFeed 	= [];
		foreach ($feeds->data as $feed) {
			$caption = (isset($feed->caption)) ? $feed->caption : $this->defaultCaption;
			$image = ($feed->media_type == 'VIDEO') ? $feed->thumbnail_url : $feed->media_url;
			$formattedFeed[] = [
				'caption' 	=> $caption,
				'image' 	=> $image,
				'link'		=> $feed->permalink,
            ];
    	}

		return $formattedFeed;
    }

    private function getFeedFromCache()
    {
    	$cacheFile = $this->cacheFile;
    	if (file_exists($cacheFile)) {
	        if ($this->isFileModifiedLessThan24Hours($cacheFile)) {
	            return unserialize(file_get_contents($cacheFile));
			}
	    }

	    return FALSE;
    }

    private function getAccessToken()
    {
        try {
            $tokenFile = $this->tokenFile;
            if (file_exists($tokenFile)) {
                $accessToken = file_get_contents($tokenFile);
                $accessToken = trim($accessToken);
                if ($this->isFileModifiedLessThan24Hours($tokenFile)) {
                    return $accessToken;
                }

                $newAccessToken = $this->refreshAccessToken($accessToken);

                file_put_contents($tokenFile, $newAccessToken);

                return $newAccessToken;
            } else {
                throw new \Exception('Token File Missing');
            }
        } catch(\Exception $e) {
            die($e->getMessage());
        }
    }

    private function refreshAccessToken($currentAccessToken)
    {
        $curlResponse = Curl::request(INSTAGRAM_REFRESH_TOKEN_API_URL . "&access_token=$currentAccessToken");

        return $curlResponse->access_token;
    }

    private function isFileModifiedLessThan24Hours($fileName)
    {
        $fileModifiedTime = time() - filemtime($fileName);
	    return ($fileModifiedTime < TWENTY_FOUR_HOURS);
    }
}
