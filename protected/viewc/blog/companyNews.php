<?php 
    include('common/top.php'); 
?>
<?php echo $this->renderBlock('companies/common/showDescription', array('company' => $company));?>
<?php echo $this->renderBlock('news/newsList', array('newsList' => $companyNews, 'pager' => $pager, 'pagerObj' => $pagerObj, 'back' => $this->__('Back to All Companies'), 'back_link' => MainHelper::site_url('news/companies'), 'headerName' => $this->__('Company News')));?>