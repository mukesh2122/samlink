<?php

class CompaniesController extends SnController {

    public function moduleOff() {
        $notAvailable = MainHelper::TrySetModuleNotAvailableByTag('contentparent');
        if ($notAvailable) {
            $data['title'] = $this->__('Companies');
            $data['body_class'] = 'index_companies';
            $data['selected_menu'] = 'companies';
            $data['left'] = PlayerHelper::playerLeftSide();
            $data['right'] = PlayerHelper::playerRightSide();
            $data['content'] = $notAvailable;
            $data['footer'] = MainHelper::bottomMenu();
            $data['header'] = MainHelper::topMenu();
            $this->render3Cols($data);
            exit;
        }
    }

    /**
     * Main website
     *
     */
    public function index() {
        $this->moduleOff();

        $companies = new Companies();
        $list = array();
        $list['CategoryType'] = null;
        $list['infoBox'] = MainHelper::loadInfoBox('Companies', 'index', true);

        $order = isset($this->params['order']) ? $this->params['order'] : '';
        if ($order != 'asc' and $order != 'desc') {
            $order = 'desc';
        }; // default by popularity desc

        $this->params['tab'] = isset($this->params['tab']) ? $this->params['tab'] : '';

        if ($this->params['tab'] == "") {
            $tabName = 'by-popularity';
        } // default by popularity
        else {
            $tabName = $this->params['tab'];
        };

        if ($this->params['tab'] == 'by-popularity') {
            $tab = 2;
        } else if ($this->params['tab'] == 'by-rating') {
            $tab = 3;
        } else if ($this->params['tab'] == 'by-date-added') {
            $tab = 4;
        } else if ($this->params['tab'] == 'alphabetically') {
            $tab = 1;
        } else {
            $tab = 2;
        }; // default by popularity

        $list['tab'] = $tab;
        $list['order'] = $order;

        $companiesTotal = $companies->getTotal();
        $pager = $this->appendPagination($list, $companies, $companiesTotal, MainHelper::site_url('companies/tab/' . $tabName . '/' . $order . '/page'), Doo::conf()->companiesLimit);
        $list['companyList'] = $companies->getAllCompanies($pager->limit, $tab, $order);

        $data['title'] = $this->__('Companies');
        $data['body_class'] = 'index_companies';
        $data['selected_menu'] = 'companies';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('companies/index', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    public function companyView() {
        $this->moduleOff();

        $company = $this->getCompany();

        $companies = new Companies();
        $list = array();
        $list['CategoryType'] = COMPANY_INFO;
        $list['infoBox'] = MainHelper::loadInfoBox('Companies', 'index', true);
        $list['companyHeader'] = $company->CompanyName;
        $list['company'] = $company;

		$dynCss = new DynamicCSS;
		$data['dynamicCss'] = $dynCss->getCustomCss('company', $this->params['company']);
        $data['title'] = $company->CompanyName;
        $data['body_class'] = 'company_view';
        $data['selected_menu'] = 'companies';
        $data['left'] = MainHelper::companiesLeftSide($company);
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('companies/companyView', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    public function ajaxRate() {
        if ($this->isAjax() and !empty($_POST) and Auth::isUserLogged()) {
            $ratings = new Ratings();
            $result['result'] = true;
            $result['rating'] = $ratings->rate('company', $_POST['ourl'], $_POST['rating']);
            if (!$result['rating']) {
                $result['result'] = false;
            }
            $this->toJSON($result, true);
        } elseif (!Auth::isUserLogged()) {
            $result['redirect'] = true;
            $this->toJSON($result, true);
        }
    }

    public function ajaxGetRating() {
        if ($this->isAjax()) {
            $vote = false;
            $companies = new Companies();
            $company = null;
            // user looks someones, or his own rating
            if (isset($_POST['ourl'])) {
                $company = $companies->getCompanyByID($_POST['ourl']);
                $isSelf = true;
                // rating is enabled or disabled
                if (isset($_POST['vote'])) {
                    $vote = $_POST['vote'];
                }
            }

            if (!$company)
                return false;

            $result['content'] = $this->renderBlock('companies/common/rating_info', array('company' => $company,
                'isSelf' => $isSelf,
                'vote' => $vote
            ));
            $result['result'] = true;
            $this->toJSON($result, true);
        }
    }

    public function newsView() {
        $this->moduleOff();

        $company = $this->getCompany();
        $news = new News();
        $companies = new Companies();
        $list = array();
        $list['CategoryType'] = COMPANY_NEWS;
        $list['infoBox'] = MainHelper::loadInfoBox('Companies', 'index', true);
        $list['isAdmin'] = $company->isAdmin();
        $list['company'] = $company;
        $pager = $this->appendPagination($list, $company, $news->getTotalByType($company->ID_COMPANY, POSTRERTYPE_COMPANY), $company->COMPANY_URL . '/news/page');
        $list['newsList'] = $news->getNewsByType($company->ID_COMPANY, POSTRERTYPE_COMPANY, $pager->limit, 1);

		$dynCss = new DynamicCSS;
		$data['dynamicCss'] = $dynCss->getCustomCss('company', $this->params['company']);
        $data['title'] = $this->__('News') . ' ' . $company->CompanyName;
        $data['body_class'] = 'company_news';
        $data['selected_menu'] = 'companies';
        $data['left'] = MainHelper::companiesLeftSide($company);
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('companies/newsView', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    /**
     * Searches for news inside company
     * @return type
     */
    public function searchNews() {
        $this->moduleOff();

        if (!isset($this->params['searchText'])) {
            DooUriRouter::redirect(MainHelper::site_url());
            return FALSE;
        };

        $company = $this->getCompany();
        $search = new Search();
        $list = array();
        $list['CategoryType'] = COMPANY_NEWS;
        $list['infoBox'] = MainHelper::loadInfoBox('Companies', 'index', true);
        $player = User::getUser();
        $list['company'] = $company;
        $list['isAdmin'] = $company->isAdmin();
        $list['searchText'] = urldecode($this->params['searchText']);
        $newsTotal = $search->getSearchTotal(urldecode($this->params['searchText']), SEARCH_NEWS, SEARCH_COMPANY, $company->ID_COMPANY);
        $pager = $this->appendPagination($list, $company, $newsTotal, $company->COMPANY_URL . '/news/search/' . urlencode($list['searchText']) . '/page');
        $list['newsList'] = $search->getSearch(urldecode($this->params['searchText']), SEARCH_NEWS, $pager->limit, SEARCH_COMPANY, $company->ID_COMPANY);
        $list['searchTotal'] = $newsTotal;

        $data['title'] = $this->__('Search results');
        $data['body_class'] = 'search_companies';
        $data['selected_menu'] = 'companies';
        $data['left'] = MainHelper::companiesLeftSide($company);
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('companies/newsView', $list);

        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    public function newsItemView() {
        $this->moduleOff();

        $company = $this->getCompany();
        if (!isset($this->params['article'])) {
            DooUriRouter::redirect($company->COMPANY_URL);
            return FALSE;
        };
        $key = $this->params['article'];
        $lang = array_search($this->params['lang'], Doo::conf()->lang);
        $list = array();
        $news = new News();
        $companies = new Companies();
        $url = Url::getUrlByName($key, URL_NEWS, $lang);
        if ($url) {
            $article = $news->getArticleByID($url->ID_OWNER, $lang);
        } else {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        };
        if (!$article) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        };

        $list['CategoryType'] = COMPANY_NEWS;
        $list['infoBox'] = MainHelper::loadInfoBox('Companies', 'index', true);
        $list['company'] = $company;
        $list['item'] = $article;
        $list['lang'] = $lang;
        $rlist = $news->getRepliesList($article->ID_NEWS, $lang, Doo::conf()->defaultShowRepliesLimit);
        $replies = '';
        if (!empty($rlist)) {
            $num = 0;
            foreach ($rlist as $nwitem) {
                $val = array('poster' => $nwitem->Players, 'item' => $nwitem, 'num' => $num);
                $replies .= $this->renderBlock('news/comment', $val);
                ++$num;
            };
        };
        $list['replies'] = $replies;

        $data['title'] = $this->__('News') . ' ' . $article->Headline;
        $data['body_class'] = 'company_news';
        $data['selected_menu'] = 'companies';
        $data['left'] = MainHelper::companiesLeftSide($company);
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('companies/articleView', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    /**
     * Main website
     *
     */
    public function gamesView() {
        $this->moduleOff();

        $company = $this->getCompany();
        $news = new News();
        $companies = new Companies();
        $list = array();
        $list['CategoryType'] = COMPANY_GAMES;
        $list['infoBox'] = MainHelper::loadInfoBox('Companies', 'index', true);
        $list['company'] = $company;
        $list['gameList'] = $companies->getGames($company);

		$dynCss = new DynamicCSS;
		$data['dynamicCss'] = $dynCss->getCustomCss('company', $this->params['company']);
        $data['title'] = $this->__('Games') . ' ' . $company->CompanyName;
        $data['body_class'] = 'company_games';
        $data['selected_menu'] = 'companies';
        $data['left'] = MainHelper::companiesLeftSide($company);
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('companies/gamesView', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    /**
     * Main website
     *
     */
    public function mediaView() {
        $this->moduleOff();

        $company = $this->getCompany();
        $companies = new Companies();
        $list = array();
        $this->addCrumb($company->CompanyName, $company->COMPANY_URL);
        $this->addCrumb($this->__('Media'));
        $list['crumb'] = $this->getCrumb();
        $list['companyHeader'] = $this->__('Media');
        $list['company'] = $company;
        $list['CategoryType'] = COMPANY_MEDIA;

        $tabs = array();
        $tabs[MEDIA_VIDEO_URL] = $this->__('Videos');
        $tabs[MEDIA_CHANNEL_URL] = $this->__('Youtube');
        $tabs[MEDIA_SCREENSHOT_URL] = $this->__('Screenshots');
        $tabs[MEDIA_CONCEPTART_URL] = $this->__('Concept Art');
        $tabs[MEDIA_WALLPAPER_URL] = $this->__('Wallpapers');

        $list['tabs'] = $tabs;
        $list['activeTab'] = !isset($this->params['tab']) ? MEDIA_VIDEO_URL : $this->params['tab'];

        switch ($list['activeTab']) {
            case MEDIA_VIDEO_URL:
                $medias = $companies->getMedias($company->ID_COMPANY, MEDIA_VIDEO);
                $list['media'] = $this->renderBlock('companies/media/video_container', array('medias' => $medias, 'company' => $company));
                break;
            case MEDIA_CHANNEL_URL:
                $medias = $companies->getMedias($company->ID_COMPANY, MEDIA_CHANNEL);
                $list['media'] = $this->renderBlock('companies/media/channel_container', array('medias' => $medias, 'company' => $company, 'mediaType' => $list['activeTab']));
                break;
            case MEDIA_SCREENSHOT_URL:
                $medias = $companies->getMedias($company->ID_COMPANY, MEDIA_SCREENSHOT);
                $list['media'] = $this->renderBlock('companies/media/image_container', array('medias' => $medias, 'company' => $company, 'mediaType' => $list['activeTab']));
                break;
            case MEDIA_CONCEPTART_URL:
                $medias = $companies->getMedias($company->ID_COMPANY, MEDIA_CONCEPTART);
                $list['media'] = $this->renderBlock('companies/media/image_container', array('medias' => $medias, 'company' => $company, 'mediaType' => $list['activeTab']));
                break;
            case MEDIA_WALLPAPER_URL:
                $medias = $companies->getMedias($company->ID_COMPANY, MEDIA_WALLPAPER);
                $list['media'] = $this->renderBlock('companies/media/image_container', array('medias' => $medias, 'company' => $company, 'mediaType' => $list['activeTab']));
                break;
            default:
                $list['activeTab'] = MEDIA_VIDEO_URL;
                $medias = $companies->getMedias($company->ID_COMPANY, MEDIA_VIDEO);
                $list['media'] = $this->renderBlock('companies/media/video_container', array('medias' => $medias, 'company' => $company));
                break;
        }

		$dynCss = new DynamicCSS;
		$data['dynamicCss'] = $dynCss->getCustomCss('company', $this->params['company']);
        $data['title'] = $this->__('Media');
        $data['body_class'] = 'index_companies';
        $data['selected_menu'] = 'companies';
        $data['left'] = MainHelper::companiesLeftSide($company, 'media');
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('companies/mediaView', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    /**
     * Renders iframe
     *
     * @return String
     */
    public function ajaxMediaView() {
        $company = $this->getCompany();
        $id = $this->params['media_id'];
        if ($this->params['tab'] == MEDIA_CHANNEL_URL) {
            if (!empty($id)) {
                $list['media'] = $this->renderBlock('companies/media/youtubevideo', array('id' => $id));
            }
        } else {
            if ($id > 0) {
                $companies = new Companies();
                $media = $companies->getMedia($id);
                $type = $media->MediaType;
                if (isset($media->ID_MEDIA)) {
                    switch ($type) {
                        case MEDIA_VIDEO:
                            $list['media'] = $this->renderBlock('companies/media/video', array('media' => $media));
                            break;
                        case MEDIA_SCREENSHOT:
                        case MEDIA_CONCEPTART:
                        case MEDIA_WALLPAPER:
                            $list['media'] = $this->renderBlock('companies/media/image', array('media' => $media));
                            break;
                    }
                }
            }
        }

        echo (isset($list['media']) && !empty($list['media'])) ? $list['media'] : "";
    }

    /**
     * searches for friend in send message field
     *
     * @return JSON
     */
    public function ajaxFindCompany() {
        if ($this->isAjax()) {
            $companies = new Companies();
            $result = $companies->getSearchCompanies($_GET['q']);
            $data = array();
            if (!empty($result)) {
                foreach ($result as $r) {
                    $img = MainHelper::showImage($r, THUMB_LIST_60x60, TRUE, array('no_img' => 'noimage/no_company_60x60.png'));
                    $data[] = array("id" => $r->ID_COMPANY, "img" => $img, "name" => $r->CompanyName);
                }
            }

            $this->toJSON($data, true);
        }
    }

    /**
     * searches companies
     *
     */
    public function search() {
        $this->moduleOff();
        $input = ($this->params['searchText']) ? urldecode($this->params['searchText']) : FALSE;
        if (FALSE === $input) {
            DooUriRouter::redirect(MainHelper::site_url('companies'));
            return FALSE;
        };

        $companies = new Companies();
        $search = new Search();
        $list = array();
        $list['CategoryType'] = null;
        $list['infoBox'] = MainHelper::loadInfoBox('Companies', 'index', true);
        $list['searchText'] = $input;

        $companiesTotal = $search->getSearchTotal($input, SEARCH_COMPANY);
        $pager = $this->appendPagination($list, $companies, $companiesTotal, MainHelper::site_url('companies/search/' . urlencode($input) . '/page'), Doo::conf()->companiesLimit);
        $list['companyList'] = $search->getSearch($input, SEARCH_COMPANY, $pager->limit);
        $list['searchTotal'] = $companiesTotal;

        $data['title'] = $this->__('Search results');
        $data['body_class'] = 'search_companies';
        $data['selected_menu'] = 'companies';
        $data['left'] = PlayerHelper::playerLeftSide();
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('companies/index', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    /**
     * Upload image
     *
     * @return JSON
     */
    public function ajaxUploadPhoto() {
        $c = new Companies();
        if (!isset($this->params['company_id']))
            return false;

        $upload = $c->uploadPhoto(intval($this->params['company_id']));

        if ($upload['filename'] != '') {
            $file = MainHelper::showImage($upload['c'], THUMB_LIST_200x300, true, array('no_img' => 'noimage/no_company_200x300.png'));
            echo $this->toJSON(array('success' => TRUE, 'img' => $file));
        } else {
            echo $this->toJSON(array('error' => $upload['error']));
        }
    }

    public function editCompanyInfo() {
        if ($this->isAjax()) {
            $company = $this->getCompany();
            if (isset($company) and User::canAccess("Edit company")) {
                $data['company'] = $company;
                $companies = new Companies();
                $data['company_types'] = $companies->getTypes();
                echo $this->renderBlock('companies/admin/editCompanyInfo', $data);
            }
        }
    }

    public function updateCompanyInfo() {
        if ($this->isAjax()) {
            $companies = new Companies();
            $company = $companies->getCompanyByID($_POST['company_id']);
            if (isset($company) and User::canAccess("Edit company")) {
                $result['result'] = $companies->updateCompanyInfo($company, $_POST);
                MainHelper::UpdateExtrafieldsByPOST('company', $_POST['company_id']);
                $this->toJSON($result, true);
            }
        }
    }

    public function addDownloadTab() {
        if ($this->isAjax()) {
            $company = $this->getCompany();
            if (isset($company) and User::canAccess("Edit company")) {
                $data['company'] = $company;
                echo $this->renderBlock('companies/admin/addDownloadTab', $data);
            }
        }
    }

    public function saveDownloadTab() {
        if ($this->isAjax()) {
            $companies = new Companies();
            $company = $companies->getCompanyByID($_POST['company_id']);
            if (isset($company) and User::canAccess("Edit company")) {
                $result['result'] = $companies->saveDownloadTab($company, $_POST);
                $this->toJSON($result, true);
            }
        }
    }

    public function editDownloadTab() {
        if ($this->isAjax()) {
            $company = $this->getCompany();
            if (isset($company) and User::canAccess("Edit company")) {
                $data['company'] = $company;
                $companies = new Companies();
                $data['tabs'] = $companies->getFiletypes($company->ID_COMPANY);
                $data['first_tabs'] = $data['tabs'][0];

                echo $this->renderBlock('companies/admin/editDownloadTab', $data);
            }
        }
    }

    public function deleteDownloadTab() {
        if ($this->isAjax()) {
            $company = $this->getCompany();
            if (isset($company) and User::canAccess("Edit company")) {
                $companies = new Companies();
                $result['result'] = $companies->deleteDownloadTab($_POST['tab_id']);
                $this->toJSON($result, true);
            }
        }
    }

    public function addDownload() {
        if ($this->isAjax()) {
            $company = $this->getCompany();
            if (isset($company) and User::canAccess("Edit company")) {
                $data['company'] = $company;
                $companies = new Companies();
                $data['tabs'] = $companies->getFiletypes($company->ID_COMPANY);
                echo $this->renderBlock('companies/admin/addDownload', $data);
            }
        }
    }

    public function saveDownload() {
        if ($this->isAjax()) {
            $companies = new Companies();
            $company = $companies->getCompanyByID($_POST['company_id']);
            if (isset($company) and User::canAccess("Edit company")) {
                $result['result'] = $companies->saveDownload($company, $_POST);
                $this->toJSON($result, true);
            }
        }
    }

    public function deleteDownload() {
        if ($this->isAjax()) {
            $companies = new Companies();
            $company = $companies->getCompanyByID($_POST['company_id']);
            if (isset($company) and User::canAccess("Edit company")) {
                $result['result'] = $companies->deleteDownload($_POST['download_id']);
                $this->toJSON($result, true);
            }
        }
    }

    public function editDownload() {
        if ($this->isAjax()) {
            $company = $this->getCompany();
            if (isset($company) and User::canAccess("Edit company")) {
                $data['company'] = $company;
                $companies = new Companies();
                $data['download'] = $companies->getDownload($this->params['download_id']);
                $data['tabs'] = $companies->getFiletypes($company->ID_COMPANY);
                echo $this->renderBlock('companies/admin/editDownload', $data);
            }
        }
    }

    public function addMedia() {
        if ($this->isAjax()) {
            $company = $this->getCompany();
            if (isset($company) and User::canAccess("Edit company")) {
                $tabs = array();
                $tabs[MEDIA_VIDEO_URL] = $this->__('Videos');
                $tabs[MEDIA_SCREENSHOT_URL] = $this->__('Screenshots');
                $tabs[MEDIA_CONCEPTART_URL] = $this->__('Concept Art');
                $tabs[MEDIA_WALLPAPER_URL] = $this->__('Wallpapers');

                $data['company'] = $company;
                $data['tabs'] = $tabs;
                echo $this->renderBlock('companies/admin/addMedia', $data);
            }
        }
    }

    public function editMedia() {
        if ($this->isAjax()) {
            $company = $this->getCompany();
            if (isset($company) and User::canAccess("Edit company")) {
                $companies = new Companies();
                $data['company'] = $company;
                $media = $companies->getMedia($this->params['media_id']);
                $tabs = array();
                $tabs1 = array();

                if ($media->MediaType == MEDIA_VIDEO) {
                    $tabs[MEDIA_VIDEO_URL] = $this->__('Videos');
                    $tabs1[MEDIA_VIDEO_URL] = MEDIA_VIDEO;
                } else {
                    $tabs[MEDIA_SCREENSHOT_URL] = $this->__('Screenshots');
                    $tabs[MEDIA_CONCEPTART_URL] = $this->__('Concept Art');
                    $tabs[MEDIA_WALLPAPER_URL] = $this->__('Wallpapers');

                    $tabs1[MEDIA_SCREENSHOT_URL] = MEDIA_SCREENSHOT;
                    $tabs1[MEDIA_CONCEPTART_URL] = MEDIA_CONCEPTART;
                    $tabs1[MEDIA_WALLPAPER_URL] = MEDIA_WALLPAPER;
                }

                $data['tabs'] = $tabs;
                $data['tabs1'] = $tabs1;
                $data['media'] = $media;
                echo $this->renderBlock('companies/admin/editMedia', $data);
            }
        }
    }

    public function saveMedia() {
        if ($this->isAjax()) {
            $company = $this->getCompany();
            if (isset($company) and User::canAccess("Edit company")) {
                $companies = new Companies();
                $result['result'] = $companies->saveMedia($_POST);
                $this->toJSON($result, true);
            }
        }
    }

    public function deleteMedia() {
        if ($this->isAjax()) {
            $company = $this->getCompany();
            if (isset($company) and User::canAccess("Edit company")) {
                $companies = new Companies();
                $result['result'] = $companies->deleteMedia($_POST['media_id']);
                $this->toJSON($result, true);
            }
        }
    }

    /**
     * Upload multi images to media
     *
     * @return JSON
     */
    public function ajaxUploadMultiPhoto() {
        $c = new Companies();
        if (!isset($this->params['company_id']))
            return false;

        $tabs = array();
        $tabs[MEDIA_SCREENSHOT_URL] = MEDIA_SCREENSHOT;
        $tabs[MEDIA_CONCEPTART_URL] = MEDIA_CONCEPTART;
        $tabs[MEDIA_WALLPAPER_URL] = MEDIA_WALLPAPER;

        $upload = $c->uploadMedias(intval($this->params['company_id']), 0, $tabs[$_POST['selected-tab']]);

        if ($upload['filename'] != '') {
            echo 1;
        } else {
            echo 'Error';
        }
    }

    public function ajaxUploadMultiVideo() {
        $c = new Companies();
        if (!isset($this->params['company_id']))
            return false;

        $videos = explode("\n", $_POST['media_videos']);

        if (!empty($videos)) {
            foreach ($videos as $video) {
                $v = ContentHelper::parseYoutubeVideo($video);
                if ($v) {
                    $c->addVideo($this->params['company_id'], $v);
                }
            }
            $result['result'] = true;
        } else {
            $result['result'] = false;
        }
        $this->toJSON($result, true);
    }

    public function addGame() {
        if ($this->isAjax()) {
            $company = $this->getCompany();
            if (isset($company) and User::canAccess("Create games")) {
                $data['company'] = $company;
                $companies = new Companies();
                $data['types'] = $companies->getGametypes();
                $data['platforms'] = $companies->getGamePlatforms();

                echo $this->renderBlock('companies/admin/addGame', $data);
            }
        }
    }

    public function saveGame() {
        if ($this->isAjax()) {
            $companies = new Companies();
            $company = $companies->getCompanyByID($_POST['company_id']);
            if (isset($company) and User::canAccess("Create games")) {
                $result['result'] = $companies->saveGame($company, $_POST);
                $this->toJSON($result, true);
            }
        }
    }

    /**
     * counts download click
     *
     * @return JSON
     */
    public function ajaxCountDownload() {
        if ($this->isAjax()) {
            $companies = new Companies();
            $companies->addDownloadCount($_POST['id']);
        }
    }

    /**
     * Toggles like/unlike for company
     *
     * @return JSON
     */
    public function ajaxToggleLike() {
        if ($this->isAjax()) {
            $player = User::getUser();
            if ($player) {
                $result['result'] = $player->toggleLikeCompany($_POST['id']);
                $player->purgeCache();
                $this->toJSON($result, true);
            }
        }
    }

    private function getCompany() {
        if (!isset($this->params['company'])) {
            DooUriRouter::redirect(MainHelper::site_url('companies'));
            return FALSE;
        }
        $key = $this->params['company'];
        $url = Url::getUrlByName($key, URL_COMPANY);
        if ($url) {
            $company = Companies::getCompanyByID($url->ID_OWNER);
        } else {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }
        if (!$company) {
            DooUriRouter::redirect(Doo::conf()->APP_URL);
            return FALSE;
        }

        return $company;
    }

    public function addNews() {
        $this->moduleOff();

        $company = $this->getCompany();
        $player = User::getUser();
        if (!$company) {
            DooUriRouter::redirect($company->COMPANY_URL);
            return FALSE;
        }
        if ($company->isAdmin() === FALSE) {
            if (!$player or $player->canAccess('Create news') === FALSE) {
                DooUriRouter::redirect($company->COMPANY_URL);
                return FALSE;
            }
        }
        $list = array();
        if (isset($_POST) and !empty($_POST)) {
            $news = new News();
            $result = $news->saveNews($_POST, 0, 0, 1);
            if ($result instanceof NwItems) {
                $translated = current($result->NwItemLocale);
                $LID = $translated->ID_LANGUAGE;
                DooUriRouter::redirect($company->COMPANY_URL . '/admin/edit-news/' . $result->ID_NEWS . '/' . $LID);
                return FALSE;
            } else {
                $list['post'] = $_POST;
            }
        }
        $games = new Games();
        $companies = new Companies();
        $news = new News();
        $companyOwners = $companies->getAllCompanies(10000, 1, "ASC"); // List of Companies / Games
        $gameOwners = $games->getAllGames(10000, 1, "ASC"); // Alternate List of Companies / Games
        $companyKeys = array(array('TypeID', 'ID_COMPANYTYPE'),
            array('OwnerID', 'ID_COMPANY'),
            array('Name', 'CompanyName'));
        $gameKeys = array(array('TypeID', 'ID_GAMETYPE'),
            array('OwnerID', 'ID_GAME'),
            array('Name', 'GameName'));
        $companytypeKeys = array(array('TypeID', 'ID_COMPANYTYPE'),
            array('Name', 'CompanyTypeName'));
        $gametypeKeys = array(array('TypeID', 'ID_GAMETYPE'),
            array('Name', 'GameTypeName'));
        $companytypes = $companies->getTypes(); // Company Types / Game Types
        $gametypes = $games->getTypes(); // Alternate Company Types / Game Types
        $list['companyOwnerArray'] = $news->populateArrayNewsAdmin($companyOwners, $companyKeys);
        $list['gameOwnerArray'] = $news->populateArrayNewsAdmin($gameOwners, $gameKeys);
        $list['ownerType'] = 'company';
        $list['function'] = 'add';
        $list['platforms'] = $games->getGamePlatforms();
        $list['typeUrl'] = $company->COMPANY_URL;
        $list['companytypes'] = $news->populateArrayNewsAdmin($companytypes, $companytypeKeys);
        $list['gametypes'] = $news->populateArrayNewsAdmin($gametypes, $gametypeKeys);
        $list['ownerID'] = $company->ID_COMPANY;
        $list['type'] = $company->ID_COMPANYTYPE;
        $list['company'] = $company;
        $list['adminPanel'] = 0;
        $list['language'] = 1;
        $list['languages'] = Lang::getLanguages();
        $list['CategoryType'] = false;
        $list['infoBox'] = MainHelper::loadInfoBox('Companies', 'index', true);
        $player = User::getUser();

        $data['title'] = $this->__('Add News');
        $data['body_class'] = 'add_news';
        $data['selected_menu'] = 'companies';
        $data['left'] = MainHelper::companiesLeftSide($company);
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('admin/news/addEditNews', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    public function chooseLang() {
        $this->moduleOff();
        if ($this->isAjax()) {
            $company = $this->getCompany();
            if (!$company or !isset($this->params['news_id'])) {
                DooUriRouter::redirect($company->COMPANY_URL);
                return FALSE;
            }
            $news = new News();
            $newsItem = $news->getArticleByID($this->params['news_id']);
            $data['lang'] = $newsItem->getTranslatedLanguages();
            $data['item'] = $newsItem;
            echo $this->renderBlock('admin/news/chooseLang', $data);
        }
    }

    public function editNews() {
        $this->moduleOff();

        $company = $this->getCompany();
        $player = User::getUser();
        if (!$company or !isset($this->params['news_id'])) {
            DooUriRouter::redirect($company->COMPANY_URL);
            return FALSE;
        }
        if ($company->isAdmin() === FALSE) {
            if (!$player or $player->canAccess('Edit news') === FALSE) {
                DooUriRouter::redirect($company->COMPANY_URL);
                return FALSE;
            }
        }

        $list = array();
        if (isset($_POST) and !empty($_POST)) {
            $news = new News();
            $result = $news->updateNews($_POST);
            if ($result instanceof NwItems) {
                $translated = current($result->NwItemLocale);
                $LID = $translated->ID_LANGUAGE;
                $lang = Lang::getLangById($LID);
                $langShort = strtolower($lang->A2);
                $url = Url::getUrlById($result->ID_NEWS, URL_NEWS, $LID);
                DooUriRouter::redirect(MainHelper::site_url('news/view/' . $langShort . '/' . $url->URL));
                return FALSE;
            } else {
                $list['post'] = $_POST;
            }
        }

        $news = new News();
        $companies = new Companies();
        $games = new Games();

        $list['company'] = $company;
        $newsItem = $news->getArticleByID($this->params['news_id'], $this->params['lang_id']);
        $translated = null;
        if (isset($newsItem->NwItemLocale)) {
            $translated = current($newsItem->NwItemLocale);
        }

        if (!isset($translated)) {
            DooUriRouter::redirect($company->COMPANY_URL . '/news');
            return FALSE;
        }
        $type = $companies->getCompanyByID($newsItem->ID_OWNER);
        $companyOwners = $companies->getAllCompanies(10000, 1, "ASC"); // List of Companies / Games
        $gameOwners = $games->getAllGames(10000, 1, "ASC"); // Alternate List of Companies / Games
        $companyKeys = array(array('TypeID', 'ID_COMPANYTYPE'),
            array('OwnerID', 'ID_COMPANY'),
            array('Name', 'CompanyName'));
        $gameKeys = array(array('TypeID', 'ID_GAMETYPE'),
            array('OwnerID', 'ID_GAME'),
            array('Name', 'GameName'));
        $companytypeKeys = array(array('TypeID', 'ID_COMPANYTYPE'),
            array('Name', 'CompanyTypeName'));
        $gametypeKeys = array(array('TypeID', 'ID_GAMETYPE'),
            array('Name', 'GameTypeName'));
        $companytypes = $companies->getTypes(); // Company Types / Game Types
        $gametypes = $games->getTypes(); // Alternate Company Types / Game Types
        $list['companyOwnerArray'] = $news->populateArrayNewsAdmin($companyOwners, $companyKeys);
        $list['gameOwnerArray'] = $news->populateArrayNewsAdmin($gameOwners, $gameKeys);
        $list['newsItem'] = $newsItem;
        $list['function'] = 'edit';
        $list['adminPanel'] = 1;
        $list['ownerType'] = 'company';
        $list['platforms'] = $games->getGamePlatforms();
        

        $list['prefixes'] = Prefix::getPrefixes(); 
        $items = new NwItems(); 
        $selected = ($this->params['news_id']);
        $selected = $items->find(array('asc' => 'ID_PREFIX', 'where' => 'ID_NEWS =' . $selected));
        $selected = $selected[0]->ID_PREFIX;      
        $list['prefix'] = $selected;
        
        $list['language'] = $this->params['lang_id'];
        $list['languages'] = Lang::getLanguages();
        $list['typeUrl'] = $company->COMPANY_URL;
        $list['companytypes'] = $news->populateArrayNewsAdmin($companytypes, $companytypeKeys);
        $list['gametypes'] = $news->populateArrayNewsAdmin($gametypes, $gametypeKeys);
        $list['ownerID'] = $newsItem->ID_OWNER;
        $list['type'] = $type->ID_COMPANYTYPE;
        $list['translated'] = $translated;
        $list['CategoryType'] = false;
        $list['infoBox'] = MainHelper::loadInfoBox('Companies', 'index', true);

        
        
        $data['title'] = $this->__('Edit News');
        $data['body_class'] = 'recent_games';
        $data['selected_menu'] = 'companies';
        $data['left'] = MainHelper::companiesLeftSide($company);
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('admin/news/addEditNews', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

    public function translateNews() {
        $this->moduleOff();

        $company = $this->getCompany();
        $player = User::getUser();
        if (!$company or !isset($this->params['news_id'])) {
            DooUriRouter::redirect($company->COMPANY_URL);
            return FALSE;
        }
        if ($company->isAdmin() === FALSE) {
            if (!$player or $player->canAccess('Translate news') === FALSE) {
                DooUriRouter::redirect($company->COMPANY_URL);
                return FALSE;
            }
        }

        $list = array();
        if (isset($_POST) and !empty($_POST)) {
            $news = new News();
            $result = $news->saveTranslation($_POST);
            if ($result instanceof NwItemLocale) {
                $LID = $result->ID_LANGUAGE;
                DooUriRouter::redirect($company->COMPANY_URL . '/admin/edit-news/' . $result->ID_NEWS . '/' . $LID);
                return FALSE;
            } else {
                $list['post'] = $_POST;
            }
        }

        $news = new News();

        $list['company'] = $company;
        $newsItem = $news->getArticleByID($this->params['news_id'], 1);
        $translated = null;
        if (isset($newsItem->NwItemLocale)) {
            $translated = current($newsItem->NwItemLocale);
        }
        if (!isset($translated)) {
            $newsItem = $news->getArticleByID($this->params['news_id']);
            if (!$newsItem) {
                DooUriRouter::redirect($company->COMPANY_URL);
            }
        }

        $list['newsItem'] = $newsItem;
        $list['translatedLangs'] = $newsItem->getTranslatedLanguages();
        $list['translated'] = $translated ? $translated : null;
        $list['languages'] = Lang::getLanguages();
        $list['infoBox'] = MainHelper::loadInfoBox('Companies', 'index', true);

        $data['title'] = $this->__('Translate News');
        $data['body_class'] = 'translate_news';
        $data['selected_menu'] = 'companies';
        $data['left'] = MainHelper::companiesLeftSide($company);
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('admin/news/translateNews', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
    }

}
