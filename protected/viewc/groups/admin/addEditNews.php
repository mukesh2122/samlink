<?php
$groupUrl = $group->GROUP_URL;
$player = User::getUser();
$addHeader = '<a class="fr fs12 group_header_button" href="'.$groupUrl.'/admin/add-news">'.$this->__('Add News +').'</a>';
include(realpath(dirname(__FILE__).'/../common/top.php')); ?>
<div class="gradient_header clearfix">
    <span class="header_name header_name_blue"><?php echo isset($newsItem) ? $this->__('Edit News') : $this->__('Create News'); ?></span>
</div>
<form method="POST" class="news_validate" enctype="multipart/form-data">
    <input type="hidden" name="published" value="0">
    <input type="hidden" name="ownerID" value="<?php echo $group->ID_GROUP; ?>">
    <input type="hidden" name="ownerType" value="<?php echo GROUP; ?>">
    <input type="hidden" name="newsID" value="<?php echo isset($newsItem) ? $newsItem->ID_NEWS : 0; ?>">
    <div class="eventCreate clearfix mt10">
        <div class="eventCreateRoundedTop"></div>
        <div class="eventCreateRoundedMiddle">
            <div class="profileEditTitle clearfix">
                <h3><?php echo $this->__('News Specifications'); ?></h3>
            </div>
            <div class="mt5 pr zi100">
                <?php if(isset($post) and isset($post['language'])) {
                    $selectedLang = $post['language'];
                } else if(isset($language)) {
                    $selectedLang = $language;
                } ?>
                <label for="newsLanguage" class="cp"><?php echo $this->__('Language'); ?></label>
                <div class="jqtransform pr border clearfix mt2">
                    <select id="newsLanguage" class="w450" name="language">
                        <?php foreach($languages as $lang): ?>
                            <option <?php echo ((isset($selectedLang) && $lang->ID_LANGUAGE == $selectedLang)) ? 'selected="selected"' : ''; ?> value="<?php echo $lang->ID_LANGUAGE; ?>"><?php echo $lang->NativeName; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <?php if(isset($newsItem)):
                $translatedLangs = $newsItem->getTranslatedLanguages($language);
                $editUrl = $groupUrl.'/admin/edit-news/'.$newsItem->ID_NEWS.'/';
                $langList = array();
                if(!empty($translatedLangs)): ?>
                    <div class="mt10"><?php echo $this->__('Switch to Translated Language'); ?></div>
                    <?php foreach($translatedLangs as $langID=>$langName) {
                        $langList[] = '<a href="'.$editUrl.$langID.'">'.$langName.'</a>';
                    };
                    echo implode(", ", $langList);
                endif;
            endif; ?>
        </div>
        <div class="eventCreateRoundedBottom"></div>
    </div>
    <div class="eventCreate clearfix mt10">
        <div class="eventCreateRoundedTop"></div>
        <div class="eventCreateRoundedMiddle">
            <div class="profileEditTitle clearfix">
                <h3><?php echo $this->__('News Content'); ?></h3>
            </div>
            
            <div class="mt5">
                <?php if(isset($post) && isset($post['name'])) {
                    $headline = $post['name'];
                } else if(isset($translated)) {
                    $headline = $translated->Headline;
                } else {
                    $headline = '';
                } ?>
                <label for="newsHeadline" class="cp"><?php echo $this->__('Headline'); ?></label>
                <div class="border mt2">
                    <input name="name" id="newsHeadline" class="news_border w450" value="<?php echo $headline; ?>">
                </div>
            </div>
            <div class="mt10">
                <?php if(isset($newsItem)):
                    $SnImages = Doo::db()->getOne('SnImages', array(
                    'limit' => 1,
                    'where' => 'ID_OWNER = ? AND OwnerType = "news" AND ImageUrl != ""',
                    'param' => array($newsItem->ID_NEWS)
                    ));
                    if(!is_object($SnImages)): ?>
                        <div class="standard_form_info_header">
                            <h2><?php echo $this->__('News photo'); ?></h2>
                            <p><?php echo $this->__('Change News photo. Use PNG, GIF or JPG.'); ?></p>
                        </div>
                        <div class="profile_foto_edit clearfix">
                            <label><?php echo $this->__('News photo'); ?></label>
                            <div class="standard_form_photo clearfix">
                                <div class="standard_form_photo_wrapper">
                                    <?php echo MainHelper::showImage($newsItem, THUMB_LIST_100x100, false, array('width', 'no_img' => 'noimage/no_game_100x100.png')); ?>
                                </div>
                                <div class="standard_form_photo_action">
                                    <a id="change_news_picture" rel="<?php echo $newsItem->ID_NEWS;?>" ownertype="news" class="button button_medium light_grey" href="javascript:void(0);"><?php echo $this->__('Upload Photo'); ?></a>
                                    <p><?php echo $this->__('Use PNG, GIF or JPG.'); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="clearfix">
                        <label><?php echo $this->__('News square photo'); ?></label>
                        <div class="standard_form_photo clearfix">
                            <div id="picture_crop_square" class="standard_form_photo_wrapper">
                                <?php echo MainHelper::showImage($newsItem, THUMB_LIST_100x100, false, array('width', 'no_img' => 'noimage/no_game_100x100.png')); ?>
                            </div>
                            <div class="standard_form_photo_action">
                                <a id="change_picture_crop_square" rel="<?php echo $newsItem->ID_NEWS; ?>" ownertype="news" orientation="square" class="change_picture_crop button button_medium light_grey" href="javascript:void(0)"><?php echo $this->__('Upload Photo'); ?></a>
                                <p><?php echo $this->__('Use PNG, GIF or JPG.'); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label><?php echo $this->__('News portrait photo'); ?></label>
                        <div class="standard_form_photo clearfix">
                            <div id="picture_crop_portrait" class="standard_form_photo_wrapper">
                                <?php echo MainHelper::showImage($newsItem, THUMB_LIST_100x150, false, array('width', 'no_img' => 'noimage/no_game_100x100.png')); ?>
                            </div>
                            <div class="standard_form_photo_action">
                                <a id="change_picture_crop_portrait" rel="<?php echo $newsItem->ID_NEWS; ?>" ownertype="news" orientation="portrait" class="change_picture_crop button button_medium light_grey" href="javascript:void(0);"><?php echo $this->__('Upload Photo'); ?></a>
                                <p><?php echo $this->__('Use PNG, GIF or JPG.'); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix">
                        <label><?php echo $this->__('News landscape photo'); ?></label>
                        <div class="standard_form_photo clearfix">
                            <div id="picture_crop_landscape" class="standard_form_photo_wrapper">
                                <?php echo MainHelper::showImage($newsItem, THUMB_LIST_100x75, false, array('width', 'no_img' => 'noimage/no_game_100x100.png')); ?>
                            </div>
                            <div class="standard_form_photo_action">
                                <a id="change_picture_crop_landscape" rel="<?php echo $newsItem->ID_NEWS; ?>" ownertype="news" orientation="landscape" class="change_picture_crop button button_medium light_grey" href="javascript:void(0);"><?php echo $this->__('Upload Photo'); ?></a>
                                <p><?php echo $this->__('Use PNG, GIF or JPG.'); ?></p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <label for="newsImage" class="cp"><?php echo $this->__('Main Image'); ?></label>
                    <?php if(isset($translated) && $translated->Image != ""): ?>
                        <div class="clearfix mt10">
                            <div class="fl mr10"><?php echo MainHelper::showImage($translated, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_news_100x100.png')); ?></div>
                            <div class="fl">
                                <input type="checkbox" name="deleteImage" value="1" id="deleteImage">
                                <label for="deleteImage" class="cp"><?php echo $this->__('Delete Image'); ?></label>
                            </div>
                        </div>
                        <div class="clear mt5">&nbsp;</div>
                    <?php endif; ?>
                    <div class="border mt2">
                        <input type="file" id="newsImage" name="Filedata">
                    </div>
                <?php endif; ?>
            </div>
            <div class="mt10">
                <?php if(isset($post) && isset($post['messageIntro'])) {
                    $intro = $post['messageIntro'];
                } else if(isset($translated)) {
                    $intro = $translated->IntroText;
                } else {
                    $intro = '';
                } ?>
                <label for="messageIntro" class="cp"><?php echo $this->__('Short Description'); ?></label>
                <div class="border mt2">
                    <?php MainHelper::loadCKE("messageIntro", $intro, array('height' => 80)); ?>
                </div>
            </div>
            <div class="mt10">
                <?php if(isset($post) && isset($post['messageText'])) {
                    $fullText = $post['messageText'];
                } else if(isset($translated)) {
                    $fullText = $translated->NewsText;
                } else {
                    $fullText = '';
                } ?>
                <label for="messageText" class="cp"><?php echo $this->__('News Text'); ?></label>
                <div class="border mt2">
                    <?php MainHelper::loadCKE("messageText", $fullText); ?>
                </div>
            </div>
            <?php if($player->canAccess('Approve news') === true): ?>
                <div class="mt10">
                    <div class="clearfix no-margin">
                        <input class="fl" <?php echo (isset($translated) && $translated->Published == 1) ? 'checked="checked"' : ''; ?> type="checkbox" id="langArticle" name="publishLangArticle" value="1" <?php //echo $lang->ID_LANGUAGE == $user->ID_LANGUAGE ? 'checked="checked"' : '';?>> 
                        <label class="fl cp" for="langArticle"><?php echo $this->__('Publish Language Article'); ?></label>
                    </div>
                    <div class="clearfix no-margin mt5">
                        <input class="fl" <?php echo (isset($newsItem) && $newsItem->Published == 1) ? 'checked="checked"' : ''; ?> type="checkbox" id="mainArticle" name="publishMainArticle" value="1" <?php //echo $lang->ID_LANGUAGE == $user->ID_LANGUAGE ? 'checked="checked"' : '';?>> 
                        <label class="fl cp" for="mainArticle"><?php echo $this->__('Publish Main Article'); ?></label>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="eventCreateRoundedBottom"></div>
    </div>
    <div class="clearfix mt10">
        <a class="roundedButton grey fl mr5 formSubmitUniversal" href="javascript:void(0);">
            <span class="lrc"></span>
            <span class="mrc pr10 pl10"><?php echo $this->__('Save'); ?></span>
            <span class="rrc"></span>
        </a>
    </div>
</form>
<script type="text/javascript">loadCheckboxes();</script>