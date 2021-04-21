<?php

class AdminCompaniesController extends AdminController {

    /**
     * Main website
     *
     */
    public function index() {
        $player = User::getUser();
        if ($player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $companies = new Companies();
        $list = array();

        $companyTypeID = isset($this->params['type_id']) ? $this->params['type_id'] : 0;
        $sortType = isset($this->params['sortType']) ? $this->params['sortType'] : 'Status';
        $sortDir = isset($this->params['sortDir']) ? $this->params['sortDir'] : 'asc';
        $pager = $this->appendPagination($list, new stdClass(), $companies->getTotal($companyTypeID), MainHelper::site_url('admin/companies' . (isset($sortType) ? ('/sort/' . $sortType . '/' . $sortDir) : '') . '/page'), Doo::conf()->adminCompaniesLimit);
        $list['companies'] = $companies->getAllCompanies($pager->limit, $sortType, $sortDir, $companyTypeID);
        $list['companyTypes'] = $companies->getTypes();
        $list['sortType'] = $sortType;
        $list['sortDir'] = $sortDir;

        $data['title'] = $this->__('Companies');
        $data['body_class'] = 'index_companies';
        $data['selected_menu'] = 'companies';
        $data['left'] = $this->renderBlock('companies/common/leftColumn', $list);
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('companies/index', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function search() {
        if (!isset($this->params['searchText'])) {
            DooUriRouter::redirect(MainHelper::site_url('companies'));
            return FALSE;
        }

        $companies = new Companies();
        $search = new Search();
        $list = array();
        $player = User::getUser();
        if ($player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $list['searchText'] = urldecode($this->params['searchText']);

        $companiesTotal = $search->getSearchTotal(urldecode($this->params['searchText']), SEARCH_COMPANY);
        ;
        $pager = $this->appendPagination($list, $companies, $companiesTotal, MainHelper::site_url('companies/search/' . urlencode($list['searchText']) . '/page'), Doo::conf()->companiesLimit);
        $list['companies'] = $search->getSearch(urldecode($this->params['searchText']), SEARCH_COMPANY, $pager->limit);
        $list['searchTotal'] = $companiesTotal;
        $list['companyTypes'] = $companies->getTypes();

        $data['title'] = $this->__('Search results');
        $data['body_class'] = 'search_companies';
        $data['selected_menu'] = 'companies';
        $data['left'] = $this->renderBlock('companies/common/leftColumn', $list);
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('companies/index', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function edit() {
        $player = User::getUser();
        if ($player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $companies = new Companies();
        $list = array();
        $company = $companies->getCompanyByID($this->params['company_id']);
        if (!$company) {
            DooUriRouter::redirect(MainHelper::site_url('admin/companies'));
        }

        $companyDownloads = $companies->getDownloadsByCompanyId($company->ID_COMPANY);
        $companyMedia = $companies->getMedias($company->ID_COMPANY);

        $companyTypes = $companies->getTypes();
        if (isset($_POST) and !empty($_POST)) {
            $companies->updateCompanyInfo($company, $_POST);
            MainHelper::UpdateExtrafieldsByPOST('company', $company->ID_COMPANY);
            DooUriRouter::redirect(MainHelper::site_url('admin/companies/edit/' . $company->ID_COMPANY));
        }

        $list['company'] = $company;
        $list['companyMedia'] = $companyMedia;
        $list['companyDownloads'] = $companyDownloads;
        $list['companyDownloadTabs'] = $companies->getFiletypes($company->ID_COMPANY);
        $list['companyTypes'] = $companyTypes;

        //Possible extrafields for this company
        $extrafields = MainHelper::GetExtraFieldsByOwnertype('company', $company->ID_COMPANY);
        $list['extrafields'] = $extrafields;

        $data['title'] = $this->__('Edit Company');
        $data['body_class'] = 'index_companies';
        $data['selected_menu'] = 'companies';
        $data['left'] = $this->renderBlock('companies/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('companies/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('companies/edit', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function newCompany() {
        $player = User::getUser();
        if ($player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $companies = new Companies();
        $list = array();
        $companyTypes = $companies->getTypes();
        if (isset($_POST) and !empty($_POST)) {
            $company = $companies->createCompanyInfo($_POST);
            MainHelper::UpdateExtrafieldsByPOST('company', $company->ID_COMPANY);
            DooUriRouter::redirect(MainHelper::site_url('admin/companies/edit/' . $company->ID_COMPANY));
        }

        $list['companyTypes'] = $companyTypes;

        //Possible extrafields for this company
        $extrafields = MainHelper::GetExtraFieldsByOwnertype('company');
        $list['extrafields'] = $extrafields;

        $data['title'] = $this->__('New Company');
        $data['body_class'] = 'index_companies';
        $data['selected_menu'] = 'companies';
        $data['left'] = $this->renderBlock('companies/common/leftColumn', $list);
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('companies/new', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function allCompanyTypes() {
        $player = User::getUser();
        if ($player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $companies = new Companies();
        $list = array();

        $pager = $this->appendPagination($list, new stdClass(), $companies->getTotalCompanyTypes(), MainHelper::site_url('admin/companies/types/page'), Doo::conf()->adminCompaniesLimit);
        $list['companyTypes'] = $companies->getTypes();

        $data['title'] = $this->__('Companies');
        $data['body_class'] = 'index_companies';
        $data['selected_menu'] = 'companies';
        $data['left'] = $this->renderBlock('companies/common/leftColumn', $list);
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('companies/companyTypes', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function newCompanyType() {
        $player = User::getUser();
        if ($player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $companies = new Companies();
        if (isset($_POST) and !empty($_POST)) {
            $companyType = $companies->createCompanyType($_POST);
            if ($companyType) {
                DooUriRouter::redirect(MainHelper::site_url('admin/companies/types'));
            }
        }
        $list = array();

        $list['companyTypes'] = $companies->getTypes();

        $data['title'] = $this->__('New Company Type');
        $data['body_class'] = 'index_companies';
        $data['selected_menu'] = 'companies';
        $data['left'] = $this->renderBlock('companies/common/leftColumn', $list);
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('companies/newType');
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function editCompanyType() {
        $player = User::getUser();
        if ($player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $companies = new Companies();
        $list = array();
        $companyType = $companies->getCompanyTypeByID($this->params['type_id']);
        if (!$companyType) {
            DooUriRouter::redirect(MainHelper::site_url('admin/companies/types'));
        }

        if (isset($_POST) and !empty($_POST)) {
            $companies->updateCompanyType($companyType, $_POST);
            DooUriRouter::redirect(MainHelper::site_url('admin/companies/types'));
        }

        $list['companyType'] = $companyType;
        $list['companyTypes'] = $companies->getTypes();

        $data['title'] = $this->__('Edit Company Type');
        $data['body_class'] = 'index_companies';
        $data['selected_menu'] = 'companies';
        $data['left'] = $this->renderBlock('companies/common/leftColumn', $list);
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('companies/editType', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function deleteCompanyType() {
        $player = User::getUser();
        if ($player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $companies = new Companies();
        $companyType = $companies->getCompanyTypeByID($this->params['type_id']);
        if (!$companyType) {
            DooUriRouter::redirect(MainHelper::site_url('admin/companies/types'));
        } else {
            $result = $companies->deletecompanyType($companyType->ID_COMPANYTYPE);
            if ($result === TRUE) {
                DooUriRouter::redirect(MainHelper::site_url('admin/companies/types'));
            }
        }
    }

    public function mergeCompanyTypes() {
        $player = User::getUser();
        if ($player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        $companies = new Companies();
        $list = array();
        $companyType = $companies->getCompanyTypeByID($this->params['type_id']);
        if (!$companyType) {
            DooUriRouter::redirect(MainHelper::site_url('admin/companies/types'));
        }

        if (isset($_POST) and !empty($_POST)) {
            $companies->mergeCompanyTypes($_POST);
            DooUriRouter::redirect(MainHelper::site_url('admin/companies/types'));
        }

        $list['typeItem'] = $companyType;
        $list['companyTypes'] = $companies->getTypes();

        $data['title'] = $this->__('Merge Company Types');
        $data['body_class'] = 'index_companies';
        $data['selected_menu'] = 'companies';
        $data['left'] = $this->renderBlock('companies/common/leftColumn', $list);
        $data['right'] = 'right';
        $data['content'] = $this->renderBlock('companies/mergeTypes', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function addMedia() {
        $companies = new Companies();
        $player = User::getUser();
        $company = $companies->getCompanyByID($this->params['company_id']);
        if (!$company || $player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }
        $tabs = array();
        $tabs[MEDIA_VIDEO] = $this->__('Videos');
        $tabs[MEDIA_SCREENSHOT] = $this->__('Screenshots');
        $tabs[MEDIA_CONCEPTART] = $this->__('Concept Art');
        $tabs[MEDIA_WALLPAPER] = $this->__('Wallpapers');

        $companyDownloads = $companies->getDownloadsByCompanyId($company->ID_COMPANY);
        $companyMedia = $companies->getMedias($company->ID_COMPANY);

        if (isset($_POST) and !empty($_POST)) {
            $check = false;
            $mediaType = $_POST['MediaType'];
            if ($mediaType == MEDIA_VIDEO) {
                $mediaParsed = ContentHelper::parseYoutubeVideo($_POST['media_videos']);
                $media = $companies->addVideo($company->ID_COMPANY, $mediaParsed, $_POST['media_videos']);
                if (isset($media) && !empty($media))
                    $check = true;
            }
            else {
                $media = $companies->uploadMedias($company->ID_COMPANY, 0, $_POST['MediaType'], $_FILES['Filedata']);
                if ($media['media'])
                    $check = true;
            }
            if ($check === true) {
                DooUriRouter::redirect(MainHelper::site_url('admin/companies/edit/' . $company->ID_COMPANY));
            }
        }

        $list = array();
        $list['company'] = $company;
        $list['tabs'] = $tabs;
        $list['companyMedia'] = $companyMedia;
        $list['companyDownloads'] = $companyDownloads;
        $list['companyDownloadTabs'] = $companies->getFiletypes($company->ID_COMPANY);
        $list['companyTypes'] = $companies->getTypes();
        
        $list['prefixes'] = Prefix::getPrefixes(); //test

        $data['title'] = $this->__('Add Media');
        $data['body_class'] = 'index_media';
        $data['selected_menu'] = 'companies';
        $data['left'] = $this->renderBlock('companies/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('companies/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('companies/addMedia', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function editMedia() {
        $companies = new Companies();
        $player = User::getUser();
        $company = $companies->getCompanyByID($this->params['company_id']);
        $medium = $companies->getMedia($this->params['media_id']);
        if (!$company || !$medium || $player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }
        $tabs = array();
        $tabs[MEDIA_SCREENSHOT] = $this->__('Screenshots');
        $tabs[MEDIA_CONCEPTART] = $this->__('Concept Art');
        $tabs[MEDIA_WALLPAPER] = $this->__('Wallpapers');

        $companyDownloads = $companies->getDownloadsByCompanyId($company->ID_COMPANY);
        $companyMedia = $companies->getMedias($company->ID_COMPANY);

        if (isset($_POST) and !empty($_POST)) {
            $check = false;
            $mediaType = $_POST['MediaType'];
            $media = $companies->updateMedia($_POST);
            if ($media === true) {
                DooUriRouter::redirect(MainHelper::site_url('admin/companies/edit/' . $company->ID_COMPANY));
            }
        }

        $list = array();
        $list['company'] = $company;
        $list['tabs'] = $tabs;
        $list['companyMedia'] = $companyMedia;
        $list['companyDownloads'] = $companyDownloads;
        $list['companyDownloadTabs'] = $companies->getFiletypes($company->ID_COMPANY);
        $list['companyTypes'] = $companies->getTypes();
        $list['mediaItem'] = $medium;

        $list['prefixes'] = Prefix::getPrefixes(); //test


        $data['title'] = $this->__('Edit Media');
        $data['body_class'] = 'index_media';
        $data['selected_menu'] = 'companies';
        $data['left'] = $this->renderBlock('companies/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('companies/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('companies/editMedia', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function deleteMedia() {
        $companies = new Companies();
        $player = User::getUser();
        $company = $companies->getCompanyByID($this->params['company_id']);
        $medium = $companies->getMedia($this->params['media_id']);
        if (!$company || !$medium || $player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        } else {
            $result = $companies->deleteMedia($medium->ID_MEDIA);
            if ($result === TRUE) {
                DooUriRouter::redirect(MainHelper::site_url('admin/companies/edit/' . $company->ID_COMPANY . '/media'));
            }
        }
    }

    public function allMedia() {
        $player = User::getUser();
        $companies = new Companies();
        $company = $companies->getCompanyByID($this->params['company_id']);
        if (!$company || $player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }


        $list = array();
        $pager = $this->appendPagination($list, new stdClass(), $companies->getTotalMediaByCompanyId($company->ID_COMPANY), MainHelper::site_url('admin/companies/edit/' . $company->ID_COMPANY . '/media/page'), Doo::conf()->adminCompaniesLimit);

        $list['company'] = $company;
        $list['companyMedia'] = $companies->getMedias($company->ID_COMPANY);
        $list['companyDownloads'] = $companies->getDownloadsByCompanyId($company->ID_COMPANY);
        $list['companyDownloadTabs'] = $companies->getFiletypes($company->ID_COMPANY);
        $list['companyTypes'] = $companies->getTypes();

        $data['title'] = $this->__('All Media');
        $data['body_class'] = 'index_media';
        $data['selected_menu'] = 'companies';
        $data['left'] = $this->renderBlock('companies/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('companies/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('companies/allMedia', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function allFiletypes() {
        $player = User::getUser();
        $companies = new Companies();
        $company = $companies->getCompanyByID($this->params['company_id']);
        if (!$company || $player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }


        $list = array();
        $pager = $this->appendPagination($list, new stdClass(), $companies->getTotalFiletypesByCompanyId($company->ID_COMPANY), MainHelper::site_url('admin/companies/edit/' . $company->ID_COMPANY . '/downloadtabs/page'), Doo::conf()->adminCompaniesLimit);

        $list['company'] = $companies->getCompanyByID($this->params['company_id']);
        $list['companyMedia'] = $companies->getMedias($company->ID_COMPANY);
        $list['companyDownloads'] = $companies->getDownloadsByCompanyId($company->ID_COMPANY);
        $list['companyDownloadTabs'] = $companies->getFiletypes($company->ID_COMPANY);
        $list['companyTypes'] = $companies->getTypes();

        $data['title'] = $this->__('All Filetypes');
        $data['body_class'] = 'index_filetypes';
        $data['selected_menu'] = 'companies';
        $data['left'] = $this->renderBlock('companies/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('companies/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('companies/allFiletypes', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function addFiletype() {
        $player = User::getUser();
        $companies = new Companies();
        $company = $companies->getCompanyByID($this->params['company_id']);
        if (!$company || $player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        if (isset($_POST) and !empty($_POST)) {
            $filetype = $companies->saveDownloadTab($company, $_POST);
            if ($filetype) {
                DooUriRouter::redirect(MainHelper::site_url('admin/companies/edit/' . $company->ID_COMPANY));
            }
        }
        $list = array();

        $list['company'] = $company;
        $list['companyMedia'] = $companies->getMedias($company->ID_COMPANY);
        $list['companyDownloads'] = $companies->getDownloadsByCompanyId($company->ID_COMPANY);
        $list['companyDownloadTabs'] = $companies->getFiletypes($company->ID_COMPANY);
        $list['companyTypes'] = $companies->getTypes();
        $list['function'] = 'add';

        $data['title'] = $this->__('New Filetype');
        $data['body_class'] = 'index_filetypes';
        $data['selected_menu'] = 'companies';
        $data['left'] = $this->renderBlock('companies/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('companies/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('companies/addEditFiletypes', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function editFiletype() {
        $player = User::getUser();
        $companies = new Companies();
        $company = $companies->getCompanyByID($this->params['company_id']);
        $filetype = $companies->getDownloadTab($this->params['tab_id']);
        if (!$company || !$filetype || $player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        if (isset($_POST) and !empty($_POST)) {
            $filetype = $companies->saveDownloadTab($company, $_POST);
            if ($filetype) {
                DooUriRouter::redirect(MainHelper::site_url('admin/companies/edit/' . $company->ID_COMPANY));
            }
        }
        $list = array();

        $list['filetypeItem'] = $filetype;
        $list['company'] = $company;
        $list['companyMedia'] = $companies->getMedias($company->ID_COMPANY);
        $list['companyDownloads'] = $companies->getDownloadsByCompanyId($company->ID_COMPANY);
        $list['companyDownloadTabs'] = $companies->getFiletypes($company->ID_COMPANY);
        $list['companyTypes'] = $companies->getTypes();
        $list['function'] = 'edit';

        $data['title'] = $this->__('Edit Filetype');
        $data['body_class'] = 'index_filetypes';
        $data['selected_menu'] = 'companies';
        $data['left'] = $this->renderBlock('companies/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('companies/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('companies/addEditFiletypes', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function deleteFiletype() {
        $player = User::getUser();
        $companies = new Companies();
        $company = $companies->getCompanyByID($this->params['company_id']);
        $filetype = $companies->getDownloadTab($this->params['tab_id']);
        if (!$company || !$filetype || $player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        } else {
            $result = $companies->deleteDownloadTab($filetype->ID_FILETYPE);
            if ($result === TRUE) {
                DooUriRouter::redirect(MainHelper::site_url('admin/companies/edit/' . $company->ID_COMPANY . '/downloadtabs'));
            }
        }
    }

    public function allDownloads() {
        $player = User::getUser();
        $companies = new Companies();
        $company = $companies->getCompanyByID($this->params['company_id']);
        if (!$company || $player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }


        $list = array();
        $pager = $this->appendPagination($list, new stdClass(), $companies->getTotalDownloadsByCompanyId($company->ID_COMPANY), MainHelper::site_url('admin/companies/edit/' . $company->ID_COMPANY . '/downloads/page'), Doo::conf()->adminCompaniesLimit);

        $list['company'] = $company;
        $list['companyMedia'] = $companies->getMedias($company->ID_COMPANY);
        $list['companyDownloads'] = $companies->getDownloadsByCompanyId($company->ID_COMPANY);
        $list['companyDownloadTabs'] = $companies->getFiletypes($company->ID_COMPANY);
        $list['companyTypes'] = $companies->getTypes();

        $data['title'] = $this->__('All Downloads');
        $data['body_class'] = 'index_downloads';
        $data['selected_menu'] = 'companies';
        $data['left'] = $this->renderBlock('companies/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('companies/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('companies/allDownloads', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function addDownload() {
        $player = User::getUser();
        $companies = new Companies();
        $company = $companies->getCompanyByID($this->params['company_id']);
        if (!$company || $player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        if (isset($_POST) and !empty($_POST)) {
            $download = $companies->saveDownload($company, $_POST);
            if ($download) {
                DooUriRouter::redirect(MainHelper::site_url('admin/companies/edit/' . $company->ID_COMPANY));
            }
        }
        $list = array();

        $list['company'] = $company;
        $list['companyMedia'] = $companies->getMedias($company->ID_COMPANY);
        $list['companyDownloads'] = $companies->getDownloadsByCompanyId($company->ID_COMPANY);
        $list['companyDownloadTabs'] = $companies->getFiletypes($company->ID_COMPANY);
        $list['companyTypes'] = $companies->getTypes();
        $list['function'] = 'add';

        $data['title'] = $this->__('New Download');
        $data['body_class'] = 'index_downloads';
        $data['selected_menu'] = 'companies';
        $data['left'] = $this->renderBlock('companies/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('companies/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('companies/addEditDownloads', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function editDownload() {
        $player = User::getUser();
        $companies = new Companies();
        $company = $companies->getCompanyByID($this->params['company_id']);
        $download = $companies->getDownload($this->params['download_id']);
        if (!$company || !$download || $player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        }

        if (isset($_POST) and !empty($_POST)) {
            $download = $companies->saveDownload($company, $_POST);
            if ($download) {
                DooUriRouter::redirect(MainHelper::site_url('admin/companies/edit/' . $company->ID_COMPANY));
            }
        }
        $list = array();

        $list['downloadItem'] = $download;
        $list['company'] = $company;
        $list['companyMedia'] = $companies->getMedias($company->ID_COMPANY);
        $list['companyDownloads'] = $companies->getDownloadsByCompanyId($company->ID_COMPANY);
        $list['companyDownloadTabs'] = $companies->getFiletypes($company->ID_COMPANY);
        $list['companyTypes'] = $companies->getTypes();
        $list['function'] = 'edit';

        $data['title'] = $this->__('Edit Download');
        $data['body_class'] = 'index_downloads';
        $data['selected_menu'] = 'companies';
        $data['left'] = $this->renderBlock('companies/common/leftColumn', $list);
        $data['right'] = $this->renderBlock('companies/common/rightColumn', $list);
        $data['content'] = $this->renderBlock('companies/addEditDownloads', $list);
        $data['header'] = $this->getMenu();
        $this->render3Cols($data);
    }

    public function deleteDownload() {
        $player = User::getUser();
        $companies = new Companies();
        $company = $companies->getCompanyByID($this->params['company_id']);
        $download = $companies->getDownload($this->params['download_id']);
        if (!$company || !$download || $player->canAccess('Edit company information') === FALSE) {
            DooUriRouter::redirect(MainHelper::site_url('admin'));
        } else {
            $result = $companies->deleteDownload($download->ID_DOWNLOAD);
            if ($result === TRUE) {
                DooUriRouter::redirect(MainHelper::site_url('admin/companies/edit/' . $company->ID_COMPANY . '/downloads'));
            }
        }
    }

}
