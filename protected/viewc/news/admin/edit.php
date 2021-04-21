<div class="comments-cont mt10">
    <div class="comments-top">
        <div class="comments-bot clearfix pr">
            <span class="fl db fclg fs12 pr5 pb5"><?php echo $this->__('Headline'); ?>:</span>
            <span class="fl db"><input name="name" class="news_name" value="<?php echo $article->Headline; ?>"></span>
        </div>
    </div>
</div>

<div id="newsGame" class="clearfix <?php echo $article->OwnerType == WALL_GAMES ? '' : 'dn'; ?>">
    <div class="comments-cont mt10">
        <div class="comments-top">
            <div class="comments-bot clearfix pr" id="game_tags_cont">
                <span class="fl db fclg fs12 pr5 pb5"><?php echo $this->__('Game'); ?>: </span>
                <span class="fl db"><?php echo $gameCompanyName; ?></span>
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
                            <input name="platforms" type="radio" <?php echo $platform->ID_PLATFORM == $article->ID_PLATFORM ? 'checked="checked"' : ''; ?> class="fl radio_dbl" id="c_<?php echo $platform->ID_PLATFORM; ?>" value ="<?php echo $platform->ID_PLATFORM; ?>">
                            <label class="fl cp" for="c_<?php echo $platform->ID_PLATFORM; ?>"><?php echo $platform->PlatformName; ?></label>
                        </div>
                    <?php endforeach; ?>
                    <div class="grid_2 alpha omega mt10">
                        <input name="platforms" type="radio" <?php echo $article->ID_PLATFORM == 0 ? 'checked="checked"' : ''; ?> class="fl" id="c_0" value ="0">
                        <label class="fl cp" for="c_0"><?php echo $this->__('All'); ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="newsCompany" class="clearfix <?php echo $article->OwnerType == WALL_COMPANIES ? '' : 'dn'; ?>">
    <div class="comments-cont mt10">
        <div class="comments-top">
            <div class="comments-bot clearfix pr" id="company_tags_cont">
                <span class="fl db fclg fs12 pr5 pb5"><?php echo $this->__('Company'); ?>: </span>
                <span class="fl db"><?php echo $gameCompanyName; ?></span>
            </div>
        </div>
    </div>
</div>

<div class="comments-cont mt10">
    <div class="comments-top">
        <div class="comments-bot clearfix pr">
            <?php if ($article->Image != ""): ?>
                <div class="clearfix">
                    <div class="fl mr10"><?php echo MainHelper::showImage($article, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_news_100x100.png')); ?></div>
                    <div class="fl">
                        <input type="checkbox" name="deleteImage" value="1" id="deleteImage">
                        <label for="deleteImage" class="cp"><?php echo $this->__('Delete Image'); ?></label>
                    </div>
                </div>

                <div class="clear mt5">&nbsp;</div>
            <?php endif; ?>

            <span class="fl fclg fs12 pr5 pb5 mt2"><?php echo $this->__('Image'); ?>:</span>
            <input type="file" name="Filedata">

        </div>
    </div>
</div>
<div class="mt10">
    <span class="fclg fs12 pr5 pb5 mt2 db"><?php echo $this->__('Intro text'); ?>:</span>
    <?php MainHelper::loadCKE("messageIntro", $article->IntroText, array('height' => 100)); ?>
</div>
<div class="mt10">
    <span class="fclg fs12 pr5 pb5 mt2 db"><?php echo $this->__('Body text'); ?>:</span>
    <?php MainHelper::loadCKE("messageText", $article->NewsText, array('height' => 100)); ?>
</div>

<div class="mt10 no-margin">
    <div><input type="checkbox" name="published" value="1" id="news_published" <?php echo $article->Published == 1 ? 'checked="checked"' : ''; ?>><label class="cp" for="news_published"><?php echo $this->__('Published'); ?></label></div>
</div>

<div class="clear mt10">&nbsp;</div>
<a href="javascript:void(0);" class="link_green fr editnews save_close"><span><span><?php echo $this->__('Save and Close'); ?></span></span></a>
<a href="javascript:void(0);" class="link_green fr editnews mr10"><span><span><?php echo $this->__('Save'); ?></span></span></a>