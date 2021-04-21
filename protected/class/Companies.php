<?php

class Companies {

    /**
     * Returns all company list
     *
     * @return SnCompanies list
     */
    public function getAllCompanies($limit, $tab = 1, $order = 'desc', $companyTypeID = 0) {
        $company = new SnCompanies;
        $companyTypeID = intval($companyTypeID);
        $order = strtoupper($order);

        if ($tab == 2) {
            $orderBy = "CurrentPop $order, HistoryPop $order";
        } else if ($tab == 3) {
            $orderBy = "SocialRating $order";
        } else if ($tab == 4) {
            $orderBy = "CreatedTime $order";
        } else if ($tab == 11) {
            $orderBy = "ID_Company $order";
        } else if ($tab == 12) {
            $orderBy = "CompanyName $order";
        } else if ($tab == 13) {
            $orderBy = "CompanyType $order";
        } else {
            $orderBy = "CompanyName $order";
        }
        $where = '';
        if ($companyTypeID > 0) {
            $where = "WHERE {$company->_table}.ID_COMPANYTYPE = $companyTypeID ";
        }

        $query = "SELECT
					{$company->_table}.*
				FROM
					`{$company->_table}`
                                $where
				ORDER BY {$orderBy}
				LIMIT $limit";

        $rs = Doo::db()->query($query);
        $list = $rs->fetchAll(PDO::FETCH_CLASS, 'SnCompanies');

        return $list;
    }

    /**
     * Returns company item
     *
     * @return SnCompanies object
     */
    public static function getCompanyByID($id) {

        if (Doo::conf()->cache_enabled == TRUE) {
            $currentDBconf = Doo::db()->getDefaultDbConfig();
            $cacheKey = md5(CACHE_COMPANY . "_{$id}_" . $currentDBconf[0] . "_" . $currentDBconf[1] . "_" . Cache::getVersion(CACHE_COMPANY . $id));

            if (Doo::cache('apc')->get($cacheKey)) {
                return Doo::cache('apc')->get($cacheKey);
            }
        }

        $item = Doo::db()->getOne('SnCompanies', array(
            'limit' => 1,
            'where' => 'ID_COMPANY = ?',
            'param' => array($id)
        ));

        if (Doo::conf()->cache_enabled == TRUE) {
            Doo::cache('apc')->set($cacheKey, $item, Doo::conf()->COMPANY_LIFETIME);
        }
        return $item;
    }

    /**
     * Returns amount of companies
     *
     * @return int
     */
    public function getTotal($companyTypeID = 0) {
        $companyTypeID = intval($companyTypeID);
        $nc = new SnCompanies();
        $where = '';
        if ($companyTypeID > 0) {
            $where = "WHERE ID_COMPANYTYPE = $companyTypeID ";
        }
        $totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $nc->_table . '` ' . $where . ' LIMIT 1');
        return $totalNum->cnt;
    }

    /**
     * Returns amount of companies
     *
     * @return int
     */
    public function getGames($company) {
        if (Doo::conf()->cache_enabled == TRUE) {
            $currentDBconf = Doo::db()->getDefaultDbConfig();
            $cacheKey = md5(CACHE_COMPANY_GAMES . "_" . $currentDBconf[0] . "_" . $currentDBconf[1] . "_{$company->ID_COMPANY}");

            if (Doo::cache('apc')->get($cacheKey)) {
                return Doo::cache('apc')->get($cacheKey);
            }
        }

        $cgr = new SnCompanyGameRel();
        $params = array();
        $params['asc'] = 'GameName';
        $params['filters'][] = array('model' => "SnCompanyGameRel",
            'joinType' => 'INNER',
            'where' => "{$cgr->_table}.ID_COMPANY = ?",
            'param' => array($company->ID_COMPANY)
        );

        $games = Doo::db()->find('SnGames', $params);

        if (Doo::conf()->cache_enabled == TRUE) {
            Doo::cache('apc')->set($cacheKey, $games, Doo::conf()->COMPANY_LIFETIME);
        }
        return $games;
    }

    /**
     * Upload handler
     *
     * @return array
     */
    public function uploadPhoto($id) {
        $c = $this->getCompanyByID($id);

        if (User::canAccess("Edit company")) {
            $image = new Image();
            $result = $image->uploadImage(FOLDER_COMPANIES, $c->ImageURL);
            if ($result['filename'] != '') {
                $c->ImageURL = ContentHelper::handleContentInput($result['filename']);
                $c->update(array('field' => 'ImageURL'));
                $c->purgeCache();
                $result['c'] = $c;
            }

            return $result;
        }
    }

    public function getFiletypes($ID_COMPANY) {
        if (intval($ID_COMPANY) > 0) {
            $params = array();
            $params['asc'] = 'FiletypeName';
            $params['where'] = "OwnerType = ? AND ID_OWNER = ?";
            $params['param'] = array(WALL_COMPANIES, $ID_COMPANY);
            $tabs = Doo::db()->find('SnFiletypes', $params);
            return $tabs;
        }

        return array();
    }

    /**
     * Returns amount of media by companyID
     *
     * @return int
     */
    public function getTotalMediaByCompanyId($companyID) {
        $media = new SnMedia();
        $totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $media->_table . '`
                                                          WHERE ID_OWNER = ' . $companyID . ' LIMIT 1');
        return $totalNum->cnt;
    }

    public function getMedias($ID_COMPANY, $type = "") {
        if (intval($ID_COMPANY) > 0) {
            $params = array();
            $params['asc'] = 'MediaName';
            if ($type != "") {
                $params['where'] = "OwnerType = ? AND ID_OWNER = ? AND MediaType = ?";
                $params['param'] = array(WALL_COMPANIES, $ID_COMPANY, $type);
            } else {
                $params['where'] = "OwnerType = ? AND ID_OWNER = ?";
                $params['param'] = array(WALL_COMPANIES, $ID_COMPANY);
            }
            $medias = Doo::db()->find('SnMedia', $params);
            return $medias;
        }

        return array();
    }

    public function getMedia($ID_MEDIA) {
        if (intval($ID_MEDIA) > 0) {
            $params = array();
            $params['limit'] = 1;
            $params['asc'] = 'MediaName';
            $params['where'] = "ID_MEDIA = ?";
            $params['param'] = array($ID_MEDIA);
            $media = Doo::db()->find('SnMedia', $params);
            return $media;
        }

        return array();
    }

    /**
     * Upload handler uses uploadify - can be added only by admin, do check in controller
     *
     * @return array
     */
    public function uploadMedias($id, $mediaID = 0, $type = MEDIA_VIDEO, $file = '') {
        $c = $this->getCompanyByID($id);
        $image = new Image();
        if ($file != '')
            $result = $image->uploadImages(FOLDER_COMPANIES, '', $file);
        else
            $result = $image->uploadImages(FOLDER_COMPANIES);
        if ($result['filename'] != '') {
            $media = new SnMedia();
            $media->ID_OWNER = $c->ID_COMPANY;
            $media->OwnerType = WALL_COMPANIES;
            $media->MediaType = $type;
            $media->MediaDesc = ContentHelper::handleContentInput($result['filename']);
            $media->MediaName = ContentHelper::handleContentInput($result['original_name']);
            $media->insert();

            $result['media'] = $media;
        }

        return $result;
    }

    /**
     * Adds video - can be added only by admin, do check in controller
     * @param int $id
     * @param String $video - serialized
     * @return boolean
     */
    public function addVideo($id, $video, $videoUrl = '') {
        $c = $this->getCompanyByID($id);
        if (User::canAccess("Edit company")) {
            $media = new SnMedia();
            $media->ID_OWNER = $c->ID_COMPANY;
            $media->OwnerType = WALL_COMPANIES;
            $media->MediaType = MEDIA_VIDEO;
            $media->MediaDesc = $video;
            $media->MediaName = '';
            if ($videoUrl != '')
                $media->URL = $videoUrl;
            $media->insert();
            return true;
        }
        return false;
    }

    /**
     * Deletes media by id - deleted can be only by admin, do check in controller
     * @param int $id
     * @return boolean
     */
    public function deleteMedia($id) {
        if (intval($id) > 0) {
            $media = new SnMedia();
            $media->ID_MEDIA = $id;

            $media = $media->getOne();

            if ($media->MediaType != MEDIA_VIDEO) {
                $image = new Image();
                $result = $image->deleteImage(FOLDER_COMPANIES, $media->MediaDesc);
            }

            $media->delete();
            return true;
        }
        return false;
    }

    /**
     * Updates media info
     * @param array $post
     * @return boolean
     */
    public function saveMedia($post) {
        if (!empty($post)) {
            $tabs = array();
            $tabs[MEDIA_SCREENSHOT_URL] = MEDIA_SCREENSHOT;
            $tabs[MEDIA_CONCEPTART_URL] = MEDIA_CONCEPTART;
            $tabs[MEDIA_WALLPAPER_URL] = MEDIA_WALLPAPER;

            $media = new SnMedia();
            $media->ID_MEDIA = $post['media_id'];
            $media->MediaType = $tabs[$post['tab']];
            $media->MediaName = ContentHelper::handleContentInput($post['media_name']);
            $media->update();
            return true;
        }
        return false;
    }

    /**
     * Updates media info
     * @param array $post
     * @return boolean
     */
    public function updateMedia($post) {
        if (!empty($post)) {

            $media = new SnMedia();
            $media->ID_MEDIA = $post['ID_MEDIA'];
            $media->MediaType = $post['MediaType'];
            $media->update();
            return true;
        }
        return false;
    }

    public function addDownloadCount($ID_DOWNLOAD) {
        if (intval($ID_DOWNLOAD) > 0) {
            $download = new SnDownloads();
            $download->ID_DOWNLOAD = $ID_DOWNLOAD;
            $download->purgeCache();
            $download = $download->getOne();

            if ($download) {
                $download->DownloadCount = $download->DownloadCount + 1;
                $download->update(array('field' => 'DownloadCount'));
            }
        }
    }

    public function createCompanyInfo($post) {
        if (!empty($post)) {
            $company = new SnCompanies();
            if (isset($post['company_name']))
                $company->CompanyName = ContentHelper::handleContentInput($post['company_name']);
            if (isset($post['company_type']))
                $company->ID_COMPANYTYPE = intval($post['company_type']);
            if (isset($post['company_headquarters']))
                $company->CompanyAddress = ContentHelper::handleContentInput($post['company_headquarters']);
            if (isset($post['company_founded']))
                $company->Founded = ContentHelper::handleContentInput($post['company_founded']);
            if (isset($post['company_ownership']))
                $company->Ownership = ContentHelper::handleContentInput($post['company_ownership']);
            if (isset($post['company_employees']))
                $company->Employees = ContentHelper::handleContentInput($post['company_employees']);
            if (isset($post['company_url']))
                $company->URL = ContentHelper::handleContentInput($post['company_url']);
            if (isset($post['company_description']))
                $company->CompanyDesc = ContentHelper::handleContentInput($post['company_description']);
            $company->ImageURL = isset($post['image_url']) ? $post['image_url'] : '';
            $company->ID_COMPANY = $company->insert();

            Url::createUpdateURL($company->CompanyName, URL_COMPANY, $company->ID_COMPANY);
            return $company;
        }
        return false;
    }

    public function updateCompanyInfo(SnCompanies $company, $post) {
        if (!empty($post)) {

            if (isset($post['company_name']))
                $company->CompanyName = $post['company_name'];
            if (isset($post['company_type']))
                $company->ID_COMPANYTYPE = intval($post['company_type']);
            if (isset($post['company_headquarters']))
                $company->CompanyAddress = ContentHelper::handleContentInput($post['company_headquarters']);
            if (isset($post['company_founded']))
                $company->Founded = ContentHelper::handleContentInput($post['company_founded']);
            if (isset($post['company_ownership']))
                $company->Ownership = ContentHelper::handleContentInput($post['company_ownership']);
            if (isset($post['company_employees']))
                $company->Employees = ContentHelper::handleContentInput($post['company_employees']);
            if (isset($post['company_url']))
                $company->URL = ContentHelper::handleContentInput($post['company_url']);
            if (isset($post['company_description']))
                $company->CompanyDesc = ContentHelper::handleContentInput($post['company_description']);
            if (isset($post['image_url'])) {
                $company->ImageURL = $post['image_url'];
            }

            $company->update();
            $this->updateCache($company);
            Url::createUpdateURL($company->CompanyName, URL_COMPANY, $company->ID_COMPANY);
            return true;
        }
        return false;
    }

    public function saveDownloadTab(SnCompanies $company, $post) {
        if (!empty($post)) {
            $tab = new SnFiletypes();
            $tab->FiletypeName = ContentHelper::handleContentInput($post['tab_name']);
            $tab->FiletypeDesc = ContentHelper::handleContentInput($post['tab_desc']);

            if (isset($post['tab_id']) && !empty($post['tab_id'])) {
                $tab->ID_FILETYPE = $post['tab_id'];
                $tab->update();
            } else {
                $tab->ID_OWNER = $company->ID_COMPANY;
                $tab->OwnerType = WALL_COMPANIES;
                $tab->insert();
            }

            return true;
        }
        return false;
    }

    /**
     * Deletes download tab by ID
     * @param int $tabID
     * @return boolean
     */
    public function deleteDownloadTab($tabID) {
        if (intval($tabID) > 0) {
            $tab = new SnFiletypes();
            $tab->ID_FILETYPE = $tabID;
            $tab->delete();
            return true;
        }
        return false;
    }

    public function saveDownload(SnCompanies $company, $post) {
        if (!empty($post)) {
            $down = new SnDownloads();
            $down->DownloadName = ContentHelper::handleContentInput($post['download_filename']);
            $down->DownloadDesc = ContentHelper::handleContentInput($post['download_description']);
            $down->FileSize = ContentHelper::handleContentInput($post['download_filesize']);
            $down->URL = ContentHelper::handleContentInput($post['download_fileurl']);
            $down->ID_FILETYPE = $post['tab_id'];

            if (isset($post['download_id']) && !empty($post['download_id'])) {
                $down->ID_DOWNLOAD = $post['download_id'];
                $down->update();
            } else {
                $down->insert();
            }

            return true;
        }
        return false;
    }

    public function saveGame(SnCompanies $company, $post) {
        if (!empty($post)) {
            $games = new Games();
            $result = $games->createGame($post);
            $this->updateCacheGames($company);
            return $result;
        }
        return false;
    }

    /**
     * Returns specified download
     * @param int $downloadID
     * @return SnDownloads
     */
    public function getDownload($downloadID) {
        if (intval($downloadID) > 0) {
            $down = new SnDownloads();
            $down->ID_DOWNLOAD = $downloadID;
            $down->purgeCache();
            $down = $down->getOne();
            return $down;
        }
        return array();
    }

    public function getDownloadsByCompanyId($ID_COMPANY) {
        if (intval($ID_COMPANY) > 0) {
            $params = array();
            $params['asc'] = 'DownloadName';
            $params['where'] = "OwnerType = ? AND ID_OWNER = ?";
            $params['param'] = array(WALL_COMPANIES, $ID_COMPANY);
            $downloads = Doo::db()->find('SnDownloads', $params);
            return $downloads;
        }
        return false;
    }

    public function deleteDownload($downloadID) {
        if (intval($downloadID) > 0) {
            $down = new SnDownloads();
            $down->ID_DOWNLOAD = $downloadID;
            $down->delete();
            return true;
        }
        return false;
    }

    public function allDownloads($limit) {
        $list = Doo::db()->find('SnDownloads', array(
            'limit' => $limit,
            'asc' => 'DownloadName'
        ));

        return $list;
    }

    public function getTotalDownloads() {
        $nc = new SnDownloads();
        $totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $nc->_table . '` LIMIT 1');
        return $totalNum->cnt;
    }

    /**
     * Returns amount of downloads by gameID
     *
     * @return int
     */
    public function getTotalDownloadsByCompanyId($gameID) {
        $downloads = new SnDownloads();
        $totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $downloads->_table . '`
                                                          WHERE ID_OWNER = ' . $gameID . ' LIMIT 1');
        return $totalNum->cnt;
    }

    /**
     * Returns amount of filetypes by gameID
     *
     * @return int
     */
    public function getTotalFiletypesByCompanyId($gameID) {
        $filetypes = new SnFiletypes();
        $totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $filetypes->_table . '`
                                                          WHERE ID_OWNER = ' . $gameID . ' LIMIT 1');
        return $totalNum->cnt;
    }

    /**
     * Returns specified filetype / DownloadTab
     * @param int $filetypeID
     * @return SnFiletypes
     */
    public function getDownloadTab($filetypeID) {
        if (intval($filetypeID) > 0) {
            $type = new SnFiletypes();
            $type->ID_FILETYPE = $filetypeID;
            $type->purgeCache();
            $type = $type->getOne();
            return $type;
        }
        return array();
    }

    /**
     * Returns company types
     *
     * @return unknown
     */
    public function getTypes() {
        $params = array();
        $params['asc'] = 'CompanyTypeName';
        $types = Doo::db()->find('SnCompanyTypes', $params);
        return $types;
    }

    /**
     * Returns company types
     *
     * @return unknown
     */
    public function getGametypes() {
        $params = array();
        $params['asc'] = 'GameTypeName';
        $types = Doo::db()->find('SnGameTypes', $params);
        return $types;
    }

    /**
     * Returns company types
     *
     * @return unknown
     */
    public function getGamePlatforms() {
        $params = array();
        $params['asc'] = 'PlatformName';
        $platforms = Doo::db()->find('SnPlatforms', $params);
        return $platforms;
    }

    public function getPlayerCompanyRel(SnCompanies $company, Players $player = null) {
        if ($player == null) {
            $player = User::getUser();
        }

        if ($player) {
            $pgr = new SnPlayerCompanyRel();
            $pgr->ID_PLAYER = $player->ID_PLAYER;
            $pgr->ID_COMPANY = $company->ID_COMPANY;
            $result = $pgr->getOne();

            return $result;
        }
    }

    /**
     * Returns all companies list, used for ajax in admin
     *
     * @return SnCompanies list
     */
    public function getSearchCompanies($phrase) {
        if (strlen($phrase) > 2) {
            $list = Doo::db()->find('SnCompanies', array(
                'limit' => 10,
                'asc' => 'CompanyName',
                'where' => 'CompanyName LIKE ?',
                'param' => array('%' . $phrase . '%')
            ));
        }

        return $list;
    }

    public function updateCache(SnCompanies $company) {
        Cache::increase(CACHE_COMPANY . $company->ID_COMPANY);
    }

    public function updateCacheGames(SnCompanies $company) {
        $currentDBconf = Doo::db()->getDefaultDbConfig();
        $cacheKey = md5(CACHE_COMPANY_GAMES . "_" . $currentDBconf[0] . "_" . $currentDBconf[1] . "_{$company->ID_COMPANY}");
        Doo::cache('apc')->flush($cacheKey);
    }

    /**
     * Returns amount of company types
     *
     * @return int
     */
    public function getTotalCompanyTypes() {
        $nc = new SnCompanyTypes();
        $totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $nc->_table . '` LIMIT 1');
        return $totalNum->cnt;
    }

    public function createCompanyType($post) {
        if (!empty($post)) {
            $type = new SnCompanyTypes();
            $type->CompanyTypeName = ContentHelper::handleContentInput($post['CompanyTypeName']);
            $type->CompanyTypeDesc = ContentHelper::handleContentInput($post['CompanyTypeDesc']);
            $type->insert();
            return $type;
        }
        return false;
    }

    public function updateCompanyType(SnCompanyTypes $type, $post) {
        if (!empty($post)) {
            $type->CompanyTypeName = ContentHelper::handleContentInput($post['CompanyTypeName']);
            $type->CompanyTypeDesc = ContentHelper::handleContentInput($post['CompanyTypeDesc']);
            $locales = Doo::db()->find('SnCompanyTypeLocale', array(
                'where' => 'ID_COMPANYTYPE = ?',
                'param' => array($type->ID_COMPANYTYPE)
            ));
            if (!empty($locales)) {
                foreach ($locales as $l) {
                    $l->delete();
                }
            }
            $type->update();
            return $type;
        }
        return false;
    }

    /**
     * Deletes company type item
     * @param int $typeID
     * @return boolean
     */
    public function deleteCompanyType($typeID) {
        $typeID = intval($typeID);

        if ($typeID > 0) {
            $companyType = $this->getCompanyTypeByID($typeID);

            $locales = Doo::db()->find('SnCompanyTypeLocale', array(
                'where' => 'ID_COMPANYTYPE = ?',
                'param' => array($companyType->ID_COMPANYTYPE)
            ));
            if (!empty($locales)) {
                foreach ($locales as $l) {
                    $l->delete();
                }
            }

            $companyType->delete();
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Merges company type items
     * @param int $typeID
     * @return boolean
     */
    public function mergeCompanyTypes($post) {
        if (!empty($post)) {
            $companyType = $this->getCompanyTypeByID(ContentHelper::handleContentInput($post['ID_COMPANYTYPE']));

            $companies = Doo::db()->find('SnCompanies', array(
                'where' => 'ID_COMPANYTYPE = ?',
                'param' => array($companyType->ID_COMPANYTYPE)
            ));
            if (!empty($companies)) {
                foreach ($companies as $c) {
                    $type = $this->getCompanyTypeByID(ContentHelper::handleContentInput($post['tab']));
                    $c->ID_COMPANYTYPE = ContentHelper::handleContentInput($post['tab']);
                    $c->CompanyType = $type->CompanyTypeName;
                    $c->update();
                }
                return TRUE;
            }
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Returns gametype item
     *
     * @return SnCompanies object
     */
    public static function getCompanyTypeByID($id) {
        $item = Doo::db()->getOne('SnCompanyTypes', array(
            'limit' => 1,
            'where' => 'ID_COMPANYTYPE = ?',
            'param' => array($id)
        ));
        return $item;
    }

}