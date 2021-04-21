<div class="fr db mt13">
    <form action="<?php echo MainHelper::site_url('news/search');?>" id="news_search_form" class="common_search_form" method="get">
        <div id="srcnews_cont" class="sprite searchcommon_input">
            <input id="searchnews" class="search_common_text" type="text" title="<?php echo $this->__('Search news...');?>" value="<?php echo isset($searchText) ? htmlspecialchars($searchText) : $this->__('Search news...');?>" />
            <a href="javascript:void(0)" class="srccommon_but" id="srcnews_but" title="<?php echo $this->__('Search');?>">&nbsp;</a>
        </div>
    </form>
</div>