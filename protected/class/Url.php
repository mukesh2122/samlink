<?php

class Url {

    public static function generateUrl($url, $urlType, $posterID = 0, $langID = 1) {

        //Convert accented characters, and remove parentheses and apostrophes
        $from = explode(',', "ą,č,ę,ė,į,š,ų,ū,ž,ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,(,),[,],'");
        $to = explode(',', 'a,c,e,e,i,s,u,u,z,c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,,,,,,');
        //Do the replacements, and convert all other non-alphanumeric characters to spaces
        $url = strtolower($url);
        $url = preg_replace('~[^\w\d]+~', '-', str_replace($from, $to, trim($url)));
        //Remove a - at the beginning or end and make lowercase
        $url = substr(preg_replace('/^-/', '', preg_replace('/-$/', '', $url)), 0, 180);

        $snUrl = new SnUrl();
        $snUrl->OwnerType = $urlType;
        $snUrl->ID_OWNER = $posterID;
        $snUrl->ID_LANGUAGE = $langID;
        $snUrl = $snUrl->getOne();

        //if url not exists
        if (!$snUrl) {
            for ($i = 0; $i < 1000; $i++) {
                $snUrl = new SnUrl();
                $snUrl->OwnerType = $urlType;
                $turl = $url;
                if ($i > 0) {
                    $turl = $url . $i;
                }
                $snUrl->URL = $turl;
				$snUrl->ID_LANGUAGE = $langID;
                $snUrl = $snUrl->getOne();

                if (!$snUrl) {
                    $url = $turl;
                    break;
                }
            }
        } else {
            //if url exists, check if nothing changed and if changed generate new and delete old
            if ($snUrl->URL != $url) {
                $snUrl->delete();

                for ($i = 0; $i < 1000; $i++) {
                    $snUrl = new SnUrl();
                    $snUrl->OwnerType = $urlType;
                    $turl = $url;
                    if ($i > 0) {
                        $turl = $url . $i;
                    }
                    $snUrl->URL = $turl;
					$snUrl->ID_LANGUAGE = $langID;
                    $snUrl = $snUrl->getOne();

                    if (!$snUrl) {
                        $url = $turl;
                        break;
                    }
                }
            } else {
                return TRUE;
            }
        }
        return $url;
    }

    /**
     *
     * @param model $obj 
     */
    public static function getUrl($obj, $type = "URL") {
        $url = "";
        $cacheKey = "";
        $currentDBconf = Doo::db()->getDefaultDbConfig();

        if ($obj instanceof SnGroups) {
            if (Doo::conf()->cache_enabled == TRUE) {
                $cacheKey = md5("{$obj->_table}_{$type}_{$obj->ID_GROUP}_".$currentDBconf[0]."_".$currentDBconf[1]."_".Cache::getVersion(CACHE_GROUP . $obj->ID_GROUP));

                if (Doo::cache('apc')->get($cacheKey)) {
                    return Doo::cache('apc')->get($cacheKey);
                }
            }

            switch ($type) {
                case 'URL':
                    $urlResult = URL::getUrlById($obj->ID_GROUP, URL_GROUP);
                    if ($urlResult) {
                        $url = MainHelper::site_url('news/group/' . $urlResult->URL);
                    } else {
                        $url = MainHelper::site_url('news/group/' . $obj->ID_GROUP);
                    }

                    break;

                case 'GROUP_URL':
                    $urlResult = URL::getUrlById($obj->ID_GROUP, URL_GROUP);

                    if ($urlResult) {
                        $url = MainHelper::site_url('group/' . $urlResult->URL);
                    } else {
                        $url = MainHelper::site_url('group/' . $obj->ID_GROUP);
                    }

                    break;
                case 'FORUM_URL':
                    $urlResult = URL::getUrlById($obj->ID_GROUP, URL_GROUP);
                    if ($urlResult) {
                        $url = MainHelper::site_url('forum/group/' . $urlResult->URL);
                    } else {
                        $url = MainHelper::site_url('forum/group/' . $obj->ID_GROUP);
                    }
                    break;
                case 'EVENTS_URL':
                    $urlResult = URL::getUrlById($obj->ID_GROUP, URL_GROUP);
                    if ($urlResult) {
                        $url = MainHelper::site_url('events/group/' . $urlResult->URL);
                    } else {
                        $url = MainHelper::site_url('events/group/' . $obj->ID_GROUP);
                    }
                    break;
                case 'RAIDS_URL':
                    $url = MainHelper::site_url('groups/raidscheduler/' . $obj->GroupName);
                    break;
            }
        } else if ($obj instanceof SnCompanies) {
            if (Doo::conf()->cache_enabled == TRUE) {
                $cacheKey = md5("{$obj->_table}_{$type}_{$obj->ID_COMPANY}_".$currentDBconf[0]."_".$currentDBconf[1]."_".Cache::getVersion(CACHE_COMPANY . $obj->ID_COMPANY));

                if (Doo::cache('apc')->get($cacheKey)) {
                    return Doo::cache('apc')->get($cacheKey);
                }
            }

            switch ($type) {
                case 'NEWS_URL':
                    $urlResult = URL::getUrlById($obj->ID_COMPANY, URL_COMPANY);
                    if ($urlResult) {
                        $url = MainHelper::site_url('news/companies/' . $urlResult->URL);
                    } else {
                        $url = MainHelper::site_url('news/companies/' . $obj->ID_COMPANY);
                    }

                    break;

                case 'COMPANY_URL':
                    $urlResult = URL::getUrlById($obj->ID_COMPANY, URL_COMPANY);

                    if ($urlResult) {
                        $url = MainHelper::site_url('company/' . $urlResult->URL);
                    } else {
                        $url = MainHelper::site_url('company/' . $obj->ID_COMPANY);
                    }

                    break;
                case 'FORUM_URL':
                    $urlResult = URL::getUrlById($obj->ID_COMPANY, URL_COMPANY);
                    if ($urlResult) {
                        $url = MainHelper::site_url('forum/company/' . $urlResult->URL);
                    } else {
                        $url = MainHelper::site_url('forum/company/' . $obj->ID_COMPANY);
                    }
                    break;
                case 'EVENTS_URL':
                    $urlResult = URL::getUrlById($obj->ID_COMPANY, URL_COMPANY);
                    if ($urlResult) {
                        $url = MainHelper::site_url('events/company/' . $urlResult->URL);
                    } else {
                        $url = MainHelper::site_url('events/company/' . $obj->ID_COMPANY);
                    }
                    break;
            }
        } else if ($obj instanceof SnGames) {
            if (Doo::conf()->cache_enabled == TRUE) {
                $cacheKey = md5("{$obj->_table}_{$type}_{$obj->ID_GAME}_".$currentDBconf[0]."_".$currentDBconf[1]."_".Cache::getVersion(CACHE_GAME . $obj->ID_GAME));

                if (Doo::cache('apc')->get($cacheKey)) {
                    return Doo::cache('apc')->get($cacheKey);
                }
            }

            switch ($type) {
                case 'NEWS_URL':
                    $urlResult = URL::getUrlById($obj->ID_GAME, URL_GAME);
                    if ($urlResult) {
                        $url = MainHelper::site_url('news/game/' . $urlResult->URL);
                    } else {
                        $url = MainHelper::site_url('news/game/' . $obj->ID_GAME);
                    }

                    break;

                case 'GAME_URL':
                    $urlResult = URL::getUrlById($obj->ID_GAME, URL_GAME);

                    if ($urlResult) {
                        $url = MainHelper::site_url('game/' . $urlResult->URL);
                    } else {
                        $url = MainHelper::site_url('game/' . $obj->ID_GAME);
                    }

                    break;
                case 'FORUM_URL':
                    $urlResult = URL::getUrlById($obj->ID_GAME, URL_GAME);
                    if ($urlResult) {
                        $url = MainHelper::site_url('forum/game/' . $urlResult->URL);
                    } else {
                        $url = MainHelper::site_url('forum/game/' . $obj->ID_GAME);
                    }
                    break;
                case 'EVENTS_URL':
                    $urlResult = URL::getUrlById($obj->ID_GAME, URL_GAME);
                    if ($urlResult) {
                        $url = MainHelper::site_url('events/game/' . $urlResult->URL);
                    } else {
                        $url = MainHelper::site_url('events/game/' . $obj->ID_GAME);
                    }
                    break;
            }
        } else if ($obj instanceof NwItems) {
            if (Doo::conf()->cache_enabled == TRUE) {
                $cacheKey = md5("{$obj->_table}_{$type}_{$obj->ID_NEWS}_".$currentDBconf[0]."_".$currentDBconf[1]."_".Cache::getVersion(CACHE_NEWS . $obj->ID_NEWS));

                if (Doo::cache('apc')->get($cacheKey)) {
                    return Doo::cache('apc')->get($cacheKey);
                }
            }

            switch ($type) {
                case 'URL':
                    $urlResult = URL::getUrlById($obj->ID_NEWS, URL_NEWS, $obj->LANG_ID);
                    if ($urlResult) {
                        $url = MainHelper::site_url(($obj->isBlog == 1 ? 'blog' : 'news').'/view/' . $obj->LANG_NAME . '/' . $urlResult->URL);
                    } else {
                        $url = MainHelper::site_url(($obj->isBlog == 1 ? 'blog' : 'news').'/view/' . $obj->ID_NEWS);
                    }
				break;
				case 'PLAIN_URL':
                    $urlResult = URL::getUrlById($obj->ID_NEWS, URL_NEWS, $obj->LANG_ID);
                    if ($urlResult) {
                        $url = $obj->LANG_NAME . '/' . $urlResult->URL;
                    } else {
                        $url = $obj->ID_NEWS;
                    }
				break;
				case 'EDIT_URL':
					if($obj->OwnerType == GAME) {
						$tempObj = new SnGames();
						$tempObj->ID_GAME = $obj->ID_OWNER;
						$url = $tempObj->GAME_URL.'/admin/edit-news/'.$obj->ID_NEWS;
					} else if($obj->OwnerType == COMPANY) {
						$tempObj = new SnCompanies();
						$tempObj->ID_COMPANY = $obj->ID_OWNER;
						$url = $tempObj->COMPANY_URL.'/admin/edit-news/'.$obj->ID_NEWS;
					} else if($obj->OwnerType == GROUP) {
						$tempObj = new SnGroups();
						$tempObj->ID_GROUP = $obj->ID_OWNER;
						$url = $tempObj->GROUP_URL.'/admin/edit-news/'.$obj->ID_NEWS;
					}
				break;
            }
        } else if ($obj instanceof NwItemLocale) {
            if (Doo::conf()->cache_enabled == TRUE) {
                $cacheKey = md5("{$obj->_table}_{$type}_{$obj->ID_NEWS}_{$obj->ID_LANGUAGE}".$currentDBconf[0]."_".$currentDBconf[1]."_".Cache::getVersion(CACHE_NEWS . $obj->ID_NEWS));

                if (Doo::cache('apc')->get($cacheKey)) {
                    return Doo::cache('apc')->get($cacheKey);
                }
            }

            switch ($type) {
                case 'URL':
                    $urlResult = URL::getUrlById($obj->ID_NEWS, URL_NEWS, $obj->ID_LANGUAGE);
                    if ($urlResult) {
                        $url = MainHelper::site_url('news/view/' . Doo::conf()->lang[$obj->ID_LANGUAGE] . '/' . $urlResult->URL);
                    } else {
                        $url = MainHelper::site_url('news/view/' . $obj->ID_NEWS);
                    }
				break;
				case 'PLAIN_URL':
                    $urlResult = URL::getUrlById($obj->ID_NEWS, URL_NEWS, $obj->ID_LANGUAGE);
                    if ($urlResult) {
                        $url = Doo::conf()->lang[$obj->ID_LANGUAGE] . '/' . $urlResult->URL;
                    } else {
                        $url = $obj->ID_NEWS;
                    }
				break;
            }
        } else if ($obj instanceof SnPlatforms) {
            if (Doo::conf()->cache_enabled == TRUE) {
                $cacheKey = md5("{$obj->_table}_{$type}_{$obj->ID_PLATFORM}_".$currentDBconf[0]."_".$currentDBconf[1]."_".Cache::getVersion(CACHE_NEWS . $obj->ID_PLATFORM));

                if (Doo::cache('apc')->get($cacheKey)) {
                    return Doo::cache('apc')->get($cacheKey);
                }
            }

            switch ($type) {
                case 'NEWS_URL':
                    $urlResult = URL::getUrlById($obj->ID_PLATFORM, URL_PLATFORM);
                    if ($urlResult) {
                        $url = MainHelper::site_url('news/platforms/' . $urlResult->URL);
                    } else {
                        $url = MainHelper::site_url('news/platforms/' . $obj->ID_PLATFORM);
                    }

                    break;
            }
		} else if ($obj instanceof FmBoards) {
			$owner = Forum::getMiniModel($obj->OwnerType, $obj->ID_OWNER);
			if($owner !== null){
				$urlResult = URL::getUrl($owner, 'FORUM_URL');
				if ($urlResult) {
					$url = $urlResult.'/'.$obj->ID_BOARD;
				} else {
					$url = MainHelper::site_url();
				}
			}
		} else if ($obj instanceof FmTopics) {
			$owner = Forum::getMiniModel($obj->OwnerType, $obj->ID_OWNER);
			if($owner !== null){
				$urlResult = URL::getUrl($owner, 'FORUM_URL');
				if ($urlResult) {
					$url = $urlResult.'/'.$obj->ID_BOARD.'/'.$obj->ID_TOPIC;
				} else {
					$url = MainHelper::site_url();
				}
			}
		} else if ($obj instanceof EvEvents) {
			$url = MainHelper::site_url('event/'.$obj->ID_EVENT);
        };

        if (Doo::conf()->cache_enabled == TRUE and $cacheKey != "") {
            Doo::cache('apc')->set($cacheKey, $url, Doo::conf()->URL_LIFETIME);
        };

        return $url;
    }

    public static function getUrlById($ID, $OwnerType, $langID = 1) {
        $url = new SnUrl();
        $url->ID_OWNER = $ID;
        $url->OwnerType = $OwnerType;
        $url->ID_LANGUAGE = $langID;
        $url = $url->getOne();
        return $url;
    }
    
	public static function getUrlByName($name, $OwnerType, $langID = 1) {
        $url = new SnUrl();
        $url->URL = $name;
        $url->OwnerType = $OwnerType;
		$url->ID_LANGUAGE = $langID;
        $url = $url->getOne();
        return $url;
    }

    public static function createUpdateURL($name, $type, $id, $langID = 1) {
        $name = URL::generateUrl($name, $type, $id, $langID);

        if ($name !== TRUE) {
            $url = new SnUrl();
            $url->OwnerType = $type;
            $url->ID_OWNER = $id;
            $url->URL = $name;
            $url->ID_LANGUAGE = $langID;
            $url->insert();
        }
    }

    public static function deleteURL($type, $id, $langID = 1) {
        $url = new SnUrl();
        $url->OwnerType = $type;
        $url->ID_OWNER = $id;
		$url->ID_LANGUAGE = $langID;
        $url->delete();
    }

    /**
     *
     * @param SnUrl $url 
     */
    public static function updateVisitCount(SnUrl &$url) {
        $player = User::getUser();
        $playerID = 0;
        $userInfo = '';
        if (!$player) {
            if (!isset($_COOKIE['rv'])) {
                $userInfo = session_id();
            } else {
                $userInfo = $_COOKIE['rv'];
            }
        } else {
            $playerID = $player->ID_PLAYER;
        }

        $url->ID_PLAYER = $playerID;
        $url->UsrInfo = $userInfo;
        $url->update(array('field' => 'ID_PLAYER,UsrInfo'));
    }

}

?>
