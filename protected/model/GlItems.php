<?php

Doo::loadCore('db/DooSmartModel');

class GlItems extends DooSmartModel {

    public $ID_NEWS;
	public $ID_SITE;
	public $ID_MASTER;
    public $ID_OWNER;
    public $ID_AUTHOR;
    public $OwnerType;
    public $ID_PLATFORM;
    public $Replies;
    public $LastReplyNum;
    public $Featured;
    public $LikeCount;
    public $DislikeCount;
    public $isInternal;
    public $PostingTime;
    public $LastActivityTime;
    public $LastUpdatedTime;
    public $ID_EVENT;
    public $Published;
    public $ShowCount;
    public $ShareCount;
    public $ID_COUNTRY;
    public $ID_AREA;
    public $isPopular;
    public $RatingTop;
    public $RatingPop;
    public $RatingCur;
    public $SocialRating;
    public $isReview;
    public $isBlog;

    //not related to db
    public $Author;
    private $Headline = "";
    private $NewsText = "";
    private $Image = "";
    private $IntroText = "";

    public $Path;
    private $URL;
    private $PLAIN_URL;
    private $EDIT_URL;
    private $LANG_ID = 1;
    private $LANG_NAME = 'en';

    public $_table = 'gl_items';
    public $_primarykey = 'ID_NEWS';
    public $_fields = array(
        'ID_NEWS',
		'ID_SITE',
		'ID_MASTER',
        'ID_OWNER',
		'ID_AUTHOR',
        'OwnerType',
        'ID_PLATFORM',
        'PostingTime',
        'LastActivityTime',
        'LastUpdatedTime',
        'Replies',
        'LastReplyNum',
        'Featured',
        'LikeCount',
        'DislikeCount',
        'isInternal',
        'ID_EVENT',
        'Published',
        'ShowCount',
        'ShareCount',
        'ID_COUNTRY',
        'ID_AREA',
        'isPopular',
        'RatingTop',
        'RatingPop',
        'SocialRating',
        'isReview',
        'isBlog'
    );

    /**
     * Adds path categories to item for display
     *
     */
    public function addRelatedCategories() {
        if (Doo::conf()->cache_enabled == TRUE) {
            $currentDBconf = Doo::db()->getDefaultDbConfig();
            $url_cache = "URL_NWITEM_{$this->OwnerType}_{$this->ID_PLATFORM}_{$this->ID_OWNER}"."_".$currentDBconf[0]."_".$currentDBconf[1];
            if (Doo::cache('apc')->get($url_cache)) {
                return $this->Path = Doo::cache('apc')->get($url_cache);
            }
        }

        switch ($this->OwnerType) {
            case 'game':
                if ($this->ID_PLATFORM > 0) {
                    $platform = new SnPlatforms();
                    $platform->ID_PLATFORM = $this->ID_PLATFORM;
                    $platform = $platform->getOne();
                    if ($platform) {
                        $data = new stdClass();
                        $data->Url = $platform->NEWS_URL;
                        $data->Title = $platform->PlatformName;
                        $this->Path[] = $data;
                    }

                    $game = Games::getGameByID($this->ID_OWNER);
					$data = new stdClass();
					$data->Url = $game->NEWS_URL;
					$data->Title = $game->GameName;
					$this->Path[] = $data;
                } else {
                    $game = Games::getGameByID($this->ID_OWNER);
					$data = new stdClass();
					$data->Url = $game->NEWS_URL;
					$data->Title = $game->GameName;
					$this->Path[] = $data;
                }
                break;
            case 'company':
                $company = Companies::getCompanyByID($this->ID_OWNER);
				$data = new stdClass();
				$data->Url = $company->NEWS_URL;
				$data->Title = $company->CompanyName;
				$this->Path[] = $data;
                break;
            case 'player':
                $player = User::getById($this->ID_OWNER);
                $data = new stdClass();
                $data->Url = $player->URL;
                $data->Title = $player->DisplayName;
                $this->Path[] = $data;
                break;
            case 'local':

                break;
        }
        if (Doo::conf()->cache_enabled == TRUE) {
            Doo::cache('apc')->set($url_cache, $this->Path, 3600);
        }
    }

	public function getLangById($id) {
		$locale = new NwItemLocale;
		$locale->ID_NEWS = $this->ID_NEWS;
		$locale->ID_LANGUAGE = $id;
		$locale->purgeCache();
		return $locale->getOne();
	}

	public function isAuthor(){
		$user = User::getUser();

		if($user){
			if($user->ID_PLAYER == $this->ID_AUTHOR)
				return true;
		}

		return false;
	}

	public function applyUserLangs($isAdmin = false) {
		if (isset($this->NwItemLocale)) {
			$player = User::getUser();
			$langs = array(1);
			if ($player) {
				$langs = explode(",", $player->OtherLanguages);
				$langs[] = $player->ID_LANGUAGE;
			}
			$langs = array_unique($langs);

			$newLocale = array();
			$wasMain = false;
			if (!empty($langs))
			{
				foreach ($this->NwItemLocale as $locale)
				{
					if($isAdmin == false and $locale->Published == 1 and (($player and $player->ID_LANGUAGE == $locale->ID_LANGUAGE) or $locale->ID_LANGUAGE == Lang::getCurrentLangID())) {
						$this->Image = $locale->Image;
						$this->Headline = $locale->Headline;
						$this->IntroText = $locale->IntroText;
						$this->NewsText = $locale->NewsText;
						$this->Replies = $locale->Replies;
						$this->LANG_ID = $locale->ID_LANGUAGE;
						$this->LANG_NAME = Doo::conf()->lang[$locale->ID_LANGUAGE];
						$wasMain = true;
					}
					if (in_array($locale->ID_LANGUAGE, $langs) || ($player and $player->canAccess('Super Admin Interface') === TRUE))
					{
						if ($this->Headline == '')
						{
							$this->Image = $locale->Image;
							$this->Headline = $locale->Headline;
							$this->IntroText = $locale->IntroText;
							$this->NewsText = $locale->NewsText;
							$this->Replies = $locale->Replies;
							$this->LANG_ID = $locale->ID_LANGUAGE;
							$this->LANG_NAME = Doo::conf()->lang[$locale->ID_LANGUAGE];
						}
						$newLocale[$locale->ID_LANGUAGE] = $locale;
					}
				}

				if(!$wasMain and isset($newLocale[1]) and ($isAdmin == true OR $newLocale[1]->Published == 1))
				{
					$this->Image = $newLocale[1]->Image;
					$this->Headline = $newLocale[1]->Headline;
					$this->IntroText = $newLocale[1]->IntroText;
					$this->Replies =  $newLocale[1]->Replies;
					$this->NewsText = $newLocale[1]->NewsText;
				}
			}

			$this->NwItemLocale = $newLocale;
		}
	}

    public function __get($attr) {
        switch ($attr) {
            case 'URL':
                $this->$attr = Url::getUrl($this, 'URL');
                break;
            case 'PLAIN_URL':
                $this->$attr = Url::getUrl($this, 'PLAIN_URL');
                break;
            case 'EDIT_URL':
                $this->$attr = Url::getUrl($this, 'EDIT_URL');
                break;
        }
        return $this->$attr;
    }

    public function __set($attr, $val) {
        return $this->{$attr} = $val;
    }

    /**
     * Checks if player is subscribed to item
     *
     * @return unknown
     */
    public function isSubscribed() {
        $p = User::getUser();
        if ($p) {
            $relation = new NwPlayerNewsRel();
            $relation->ID_NEWS = $this->ID_NEWS;
            $relation->ID_PLAYER = $p->ID_PLAYER;
            $relation = $relation->getOne();
            if ($relation)
                return TRUE;
        }
        return FALSE;
    }

	public function getTranslatedLanguages($excludeID = 0, $asObj = false) {
		$list = Doo::db()->find('NwItemLocale', array(
			'where' => 'ID_NEWS = ? AND ID_LANGUAGE != ?',
			'param' => array($this->ID_NEWS, $excludeID)
		));

		if($asObj == true) {
			return $list;
		}

		$result = array();
		if($list) {
			foreach($list as $l) {
				$result[$l->ID_LANGUAGE] = Doo::conf()->langName[$l->ID_LANGUAGE];
			}
		}
		return $result;
	}

	public function getOwner() {
		$obj = new stdClass();
		$url = "";
		$name = "";
		if($this->OwnerType == GAME) {
			$tempObj = new SnGames();
			$tempObj->ID_GAME = $this->ID_OWNER;
			$url = $tempObj->GAME_URL;
			$name = $tempObj->getOne()->GameName;
		} else if($this->OwnerType == COMPANY) {
			$tempObj = new SnCompanies();
			$tempObj->ID_COMPANY = $this->ID_OWNER;
			$url = $tempObj->COMPANY_URL;
			$name = $tempObj->getOne()->CompanyName;
		} else if($this->OwnerType == GROUP) {
			$tempObj = new SnGroups();
			$tempObj->ID_GROUP = $this->ID_OWNER;
			$url = $tempObj->GROUP_URL;
			$name = $tempObj->getOne()->GroupName;
		}
		$obj->name = $name;
		$obj->url = $url;

		return $obj;
	}
        public function getPublisher(){
            $author = User::getByID($this->ID_AUTHOR);
            
            $obj = new stdClass();
            $name = $author->DisplayName;
            $crawler = false;
            
            if($this->ID_AUTHOR == 0){
                if(isset($this->NwItemLocale) and !empty($this->NwItemLocale)){
                    foreach($this->NwItemLocale as $crawler){                        
                        if(isset($crawler->URL) and !empty($crawler->URL))
                            $crawler = true;
                    }
                }
            }
            
            $obj->name = $name;
            $obj->crawler = $crawler;
            
            return $obj;                
        }

    /**
     * Forms url for news item in specified areas: company -> news; game -> news
     * @param SnCompanies $obj
     * @return string
     * @todo implement proper url for news item
     */
    public function getUrl($obj) {
        $url = '';
        if($obj instanceof SnCompanies) {
            $url = $obj->COMPANY_URL.'/news/'.$this->ID_NEWS;
        } elseif ($obj instanceof SnGames) {
            $url = $obj->GAME_URL.'/news/'.$this->ID_NEWS;
        }

        return $url;
    }

}
?>