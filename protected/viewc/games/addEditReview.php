<?php
$gameUrl = $game->GAME_URL;
$player = User::getUser();
include('common/top.php');
if(isset($post)): ?>
	<div class="error pt10"><?php echo $this->__('Error. News could not be saved!'); ?></div>
<?php endif; ?>

<form method="POST" class="news_validate" enctype="multipart/form-data">
	<input type="hidden" name="published" id="published" value="<?php echo isset($newsItem) ? $newsItem->Published : 0; ?>">
	<input type="hidden" name="ownerID" value="<?php echo $game->ID_GAME; ?>">
	<input type="hidden" name="ownerType" value="<?php echo GAME; ?>">
	<input type="hidden" name="newsID" value="<?php echo isset($newsItem) ? $newsItem->ID_NEWS : 0; ?>">

	<div class="eventCreate clearfix mt10">
		<div class="eventCreateRoundedTop"></div>
		<div class="eventCreateRoundedMiddle">
			<div class="profileEditTitle clearfix">
				<h3><?php echo $this->__('Review Specifications'); ?></h3>
			</div>

			<div class="mt5 pr zi100">
				<?php
					if(isset($post) and isset($post['language'])) { $selectedLang = $post['language']; }
                    else if(isset($language)) { $selectedLang = $language; };
				?>
				<label for="newsLanguage" class="cp"><?php echo $this->__('Language'); ?></label>
				<div class="jqtransform pr border clearfix mt2">
					<select id="newsLanguage" class="w450" name="language">
						<?php foreach ($languages as $lang): ?>
							<option <?php echo ((isset($selectedLang) and $lang->ID_LANGUAGE == $selectedLang)) ? 'selected="selected"' : ''; ?> value="<?php echo $lang->ID_LANGUAGE; ?>"><?php echo $lang->NativeName; ?></option>
                        <?php endforeach; ?>
					</select>
				</div>
			</div>

			<?php if(isset($newsItem)):
                $translatedLangs = $newsItem->getTranslatedLanguages($language);
                $editUrl = $gameUrl.'/admin/edit-news/'.$newsItem->ID_NEWS.'/';
                $langList = array();
				if(!empty($translatedLangs)) {
					?>
					<div class="mt10"><?php echo $this->__('Switch to Translated Language'); ?></div>
					<?php
					foreach($translatedLangs as $langID=>$langName) { $langList[] = '<a href="'.$editUrl.$langID.'">'.$langName.'</a>'; };
					echo implode(", ", $langList);
				};
			endif; ?>
            <label for="reviewRating" class="cp"><?php echo $this->__('Rating'); ?></label>                
            <div class="jqtransform pr border clearfix mt2">
                <select id="reviewRating" class="w450" name="rating">
                    <option value="0"><?php echo $this->__('Rate this game'); ?></option>
                    <?php for($i = 1; $i <= 10; ++$i): ?>
                        <option value="<?php echo $i; ?>" <?php echo !empty($userRating) && $userRating->Rating == $i ? 'selected = "selected"' : ''; ?>><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
		<div class="eventCreateRoundedBottom"></div>
	</div>

	<div class="eventCreate clearfix mt10">
		<div class="eventCreateRoundedTop"></div>
		<div class="eventCreateRoundedMiddle">
			<div class="profileEditTitle clearfix">
				<h3><?php echo $this->__('Review Content'); ?></h3>
			</div>

			<div class="mt5">
				<?php
					if(isset($post) and isset($post['name'])) { $headline = $post['name']; }
                    else if(isset($translated)) { $headline = $translated->Headline; }
                    else { $headline = ''; };
				?>
				<label for="newsHeadline" class="cp"><?php echo $this->__('Headline'); ?></label>
				<div class="border mt2">
					<input name="name" id="newsHeadline" class="news_border w450" value="<?php echo $this->__($headline); ?>">
				</div>
			</div>

			<div class="mt10">
				<label for="newsImage" class="cp"><?php echo $this->__('Main Image'); ?></label>
				<?php if(isset($translated) and $translated->Image != ""): ?>
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
			</div>

			<div class="mt10">
				<?php
					if(isset($post) and isset($post['messageIntro'])) { $intro = $post['messageIntro']; }
                    else if(isset($translated)) { $intro = $translated->IntroText; }
                    else { $intro = ''; };
				?>
				<label for="messageIntro" class="cp"><?php echo $this->__('Short Description'); ?></label>
				<div class="border mt2">
					<?php MainHelper::loadCKE("messageIntro", $this->__($intro), array('height' => 80)); ?>
				</div>
			</div>

			<div class="mt10">
				<?php
					if(isset($post) and isset($post['messageText'])) { $fullText = $post['messageText']; }
                    else if(isset($translated)) { $fullText = $translated->NewsText; }
                    else { $fullText = ''; };
				?>
				<label for="messageText" class="cp"><?php echo $this->__('Review Text'); ?></label>
				<div class="border mt2">
					<?php MainHelper::loadCKE("messageText", $this->__($fullText), array('height' => 400)); ?>
				</div>
			</div>
		</div>
		<div class="eventCreateRoundedBottom"></div>
	</div>

	<div class="clearfix mt10">
		<a class="button button_auto light_blue pull_left F_savePublishReview" href="javascript:void(0);">
			<span class="lrc"></span>
			<span class="mrc pr10 pl10"><?php echo $this->__('Save and publish'); ?></span>
			<span class="rrc"></span>
		</a>
		<a class="button button_auto light_blue pull_right F_saveReview" href="javascript:void(0);">
			<span class="lrc"></span>
			<span class="mrc pr10 pl10"><?php echo $this->__('Save'); ?></span>
			<span class="rrc"></span>
		</a>
	</div>
</form>
<script type="text/javascript">loadCheckboxes();</script>