<div class="clearfix <?php echo !isset($hideAdd) ? 'mt10' : '';?> header news clearfix">
    <a href="<?php echo MainHelper::site_url('news');?>" class="fl"><?php echo $this->__('News');?></a>
</div>
<?php if(isset($crumb)):?>
    <div class="clearfix">
        <?php echo $this->renderBlock('common/breadcrumb', array('crumb' => $crumb));?>
        
        <?php 
            if(isset($searchText)) {
                echo $this->renderBlock('news/common/search_block', array('searchText' => $searchText));
            } else {
                echo $this->renderBlock('news/common/search_block', array());
            }
            
        ?>
    </div>
<div class="clear">&nbsp;</div>
<?php endif; ?>

<form action="<?php echo MainHelper::site_url('news/save');?>" method="post" enctype="multipart/form-data" id="addnew_form">
    <input type="hidden" name="save_close" id="save_close" value="0" />
    <div class="clearfix mt10">
        <div class="fs14 fl"><?php echo $this->__('News Type');?>:</div>
        <div class="grid_2 mt3 clearfix">
            <div><input type="radio" name="newsType" value="1" class="newsType" id="typeGame" checked="checked"/> <label class="cp" for="typeGame">Game</label></div>
            <div class="mt3"><input type="radio" name="newsType" class="newsType" value="2" id="typeCompany"/> <label class="cp" for="typeCompany">Companies</label></div>
        </div>
    </div>
    <div class="comments-cont mt10">
        <div class="comments-top">
            <div class="comments-bot clearfix pr">
                <span class="fl db fclg fs12 pr5 pb5"><?php echo $this->__('Headline'); ?>:</span>
                <span class="fl db"><input name="name" class="news_name" value="" /></span>
            </div>
        </div>
    </div>

    <div id="newsGame" class="clearfix">
        <div class="comments-cont mt10">
            <div class="comments-top">
                <div class="comments-bot clearfix pr" id="game_tags_cont">
                    <span class="fl db fclg fs12 pr5 pb5"><?php echo $this->__('Search game...'); ?></span>
                    <span class="fl db"><input name="game_id" class="dn" id="game_tags" value="" /></span>
                </div>
            </div>
        </div>
        <div class="comments-cont mt10">
            <div class="comments-top">
                <div class="comments-bot clearfix pr">
                    <span class="db fclg fs12 pr5 pb5"><?php echo $this->__('Platforms'); ?>:</span>
                    <div class="clear">&nbsp;</div>
                    <div class="w580 clearfix">
                        <?php foreach ($platforms as $platform): ?>
                            <div class="grid_2 alpha omega mt10">
                                <input name="platforms[]" type="checkbox" class="fl" id="c_<?php echo $platform->ID_PLATFORM; ?>" value ="<?php echo $platform->ID_PLATFORM; ?>" />
                                <label class="fl cp" for="c_<?php echo $platform->ID_PLATFORM; ?>"><?php echo $platform->PlatformName; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="newsCompany" class="clearfix dn">
        <div class="comments-cont mt10">
            <div class="comments-top">
                <div class="comments-bot clearfix pr" id="company_tags_cont">
                    <span class="fl db fclg fs12 pr5 pb5"><?php echo $this->__('Search company...'); ?></span>
                    <span class="fl db"><input name="company_id" class="dn" id="company_tags" value="" /></span>
                </div>
            </div>
        </div>
    </div>

    <div class="comments-cont mt10">
        <div class="comments-top">
            <div class="comments-bot clearfix pr">
                <span class="fl fclg fs12 pr5 pb5 mt2"><?php echo $this->__('Image'); ?>:</span>
                <input type="file" name="Filedata" />
            </div>
        </div>
    </div>
    <div class="mt10">
        <span class="fclg fs12 pr5 pb5 mt2 db"><?php echo $this->__('Intro text'); ?>:</span>
        <?php MainHelper::loadCKE("messageIntro", "", array('height' => 100));?>
    </div>
    <div class="mt10">
        <span class="fclg fs12 pr5 pb5 mt2 db"><?php echo $this->__('Body text'); ?>:</span>
        <?php MainHelper::loadCKE("messageText", "", array('height' => 500));?>
    </div>

    <div class="mt10 no-margin">
        <div><input type="checkbox" name="published" value="1" id="news_published"/> <label class="cp" for="news_published"><?php echo $this->__('Published');?></label></div>
    </div>

    <div class="clear mt10">&nbsp;</div>
    <a href="javascript:void(0)" class="link_green fr addnews save_close"><span><span><?php echo $this->__('Save and Close'); ?></span></span></a>
    <a href="javascript:void(0)" class="link_green fr addnews mr10"><span><span><?php echo $this->__('Save'); ?></span></span></a>

</form>

        
<script type="text/javascript">loadGroup(); loadCheckboxes();</script>