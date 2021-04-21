<script type="text/javascript">
	function createHightlightUploader(ids, text, url, size) {
		
		var sizeAction = (url.indexOf('?') > -1) ? '&' : '?';
		sizeAction += 'DestWidth='+size.x+'&DestHeight='+size.y;
	    
	    return new qq.FileUploader({
	        debug: false,
	        sizeLimit: 2097152,
	        textUpload: text,
	        element: document.getElementById(ids),
	        listElement: document.getElementById('img_load'), // ???
	        action: site_url + url,
	        multiple: false,
	        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
	        acceptTypes: 'image/*',
	        onSubmit: function(id, fileName){
	        	/*
	            	$('.personal_profile_short').addClass('dn');
	            	$("#img_load").removeClass('dn').html('');
	            */
	        },
	        onComplete: function(id, fileName, responseJSON){
	            if(responseJSON.error) {
	                return false;
	            }

	            /*
	            	$('.personal_profile_short').removeClass('dn');
	            	$("#img_load").addClass('dn');
	            */

	            if(true){
	                var aspectRatio = size.x/size.y;
	                var cropLength = Array;

	                $("body").addClass('index_events_create');
	                $("body").append('<div id="openWindow_'+ids+'"></div>');
	                
	                $('#openWindow_'+ids).html('<img id="'+ids+'_load" />'); // ??
	                
	                $('#'+ids+'_load').attr('src', responseJSON.img800x600).load(function() {
	                    $('#openWindow_'+ids).dialog({
	                        title: 'Select part of image',
	                        resizable: false,
	                        modal: true,
	                        width: 825,
	                        autoOpen: true,
	                        close: function() {
	                            $(this).dialog('destroy');
	                            $(this).remove();
	                        },
	                        buttons: {
	                            Crop: function() {
	                                $.ajax({
	                                    url: site_url + url + sizeAction,
	                                    type: 'POST',
	                                    dataType: 'json',
	                                    data: cropLength,
	                                }).done(function( responseJSON ) {
	                                    if(responseJSON.img) {
	                                    	var imageName = responseJSON.img.substring(responseJSON.img.lastIndexOf('/')+1);
	                                    	$('select[name=Image]').append($('<option class="centered" value="'+imageName+'" selected="selected">'+imageName+'</option>'));
	                                    }
	                                });
	                                
	                                $(this).dialog('destroy');
	                                $(this).remove();
	                            },
	                        }
	                    }).ready(function(){
	                        $('#'+ids+'_load').Jcrop({
	                            aspectRatio: aspectRatio,
	                            bgColor: 'black',
	                            bgOpacity: .6,
	                            minSize: [size.x, size.y],
	                            //maxSize: [size.x, size.y],
	                            setSelect:   [ 0, 0, size.x, size.y ],
	                            onSelect: function updateCoords(c) {
	                                cropLength = c;
	                            },
	                        });
	                    });
	                });
	            }
	        }
	    });
	}
</script>
<?php if(isset($highlights) and !empty($highlights)):?>
	<?php $highlight = $highlights[0]; ?>
	<form method="post" action="<?php echo MainHelper::site_url('admin/news/frontpage/highlights/edit/'.$highlight->ID_HIGHLIGHT); ?>">
		<input type="hidden" name="ID_HIGHLIGHT" value="<?php echo $highlight->ID_HIGHLIGHT; ?>"> 
		<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
			<thead>
				<tr>
					<th class="centered"><?php echo $this->__('Image');?></th>
					<th class="centered"><?php echo $this->__('URL');?></th>
					<th class="centered"><?php echo $this->__('Priority');?></th>
					<th class="centered"><?php echo $this->__('Active');?></th>
				</tr>
				<tr>
					<th class="centered"><?php echo $this->__('Headline');?></th>
					<th class="centered" colspan="3"><?php echo $this->__('IntroText');?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="centered">
						<select class="size_80 centered" name="Image">
							<?php foreach ($files as $file) : ?>
								<option class="centered" value="<?php echo $file; ?>" <?php echo ($file == $highlight->Image) ? 'selected' : ''; ?>>
									<?php echo utf8_encode($file); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</td>
					<td class="centered">
						<input class="size_80 centered" type="text" name="URL" value="<?php echo $highlight->URL; ?>" />
					</td>
					<td class="centered">
						<select class="size_80 centered" name="Priority">
							<?php for ($prio = 1; $prio < 10; ++$prio) : ?>
								<option class="centered" value="<?php echo $prio; ?>" <?php echo ($prio == $highlight->Priority) ? 'selected' : ''; ?>>
									<?php echo $prio; ?>
								</option>
							<?php endfor; ?>
						</select>
					</td>
					<td class="centered">
						<select class="size_80 centered" name="isActive">
							<option class="centered" value="1" <?php echo ($highlight->isActive) ? 'selected' : '' ?>>
								<?php echo $this->__('Yes'); ?>
							</option>
							<option class="centered" value="0" <?php echo (!$highlight->isActive) ? 'selected' : '' ?>>
								<?php echo $this->__('No'); ?>
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="centered">
						<textarea rows="1" cols="30" name="Headline" onkeyup="t=this.value;this.rows = Math.floor(t.length / this.cols) + t.split('\n').length;"><?php echo $highlight->Headline; ?></textarea>
					</td>
					<td class="centered" colspan="3">
						<textarea rows="1" cols="50" name="IntroText" onkeyup="t=this.value;this.rows = Math.floor(t.length / this.cols) + t.split('\n').length;"><?php echo $highlight->IntroText; ?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="7">
						<script type="text/javascript">
							var uploaderVar = null;
							$(window).load(function() {
								uploaderVar = createHightlightUploader('upload-container', "<?php echo $this->__('Upload'); ?>", 'hacks/imageReceiver.php?folder=news_highlights', { x: 250, y: 171 });
							});
						</script>
						<div id="upload-container" class="button button_auto light_blue pull_left"></div>
						<input type="submit" class="button button_auto light_blue pull_right" value="<?php echo $this->__('Save'); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</form>
<?php endif; ?>
